<?php

// initialisations du projet
require_once $PATH.'inc/class.Session.php';
Session::init();
require_once $PATH.'inc/class.PDOTrombi.php';
$_GLOBAL['titre'] = "Trombi";
include 'vues/v_entete.php';
// constantes 
define("EOL", "<br />\n"); // fin de ligne html et saut de ligne
define("EL", "\n"); //  saut de ligne 
// instanciation du modèle PDO
$pdo = PDOTrombi::getPdoTrombi($PATH);
$tabJour = array("lundi ", "mardi ", "mercredi ", "jeudi ", "vendredi ");
$tabMois = array("janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre");
$_SESSION['debug'] = "hidden";
// dossier des uploads
$DOSSIERUPLOAD = 'upload/';

// TODO effacer le mode debug
//$_SESSION['debug']="text";
// instanciation de la fabrique de vue
//$vue = FabriqueVue::getFabrique();
//print_r ($_REQUEST);

function clean($texte) {
    return (htmlspecialchars(trim($texte)));
}

function cleanaff($texte) {//utf8_decode
    return stripslashes(htmlspecialchars(trim($texte)));
}

/*
 * déconnecte l'utilisateur et redirige le traitement sur la page menu
 */

function logout() {
    Session::logout();
    unset($_SESSION['pseudo']);
    $_SESSION['debug'] = "hidden";
    unset($_SESSION['tsDerniereCx']);
    unset($_SESSION['numUtil']);
    header('Location: index.php?uc=lecture&num=actuelle');
}

/*
 * Renvoie le mot $mot au pluriel s'il y a lieu de l'être
 */

function pluriel($n, $mot) {
    if ($n > 1) {
        return $mot . 's';
    }
    return $mot;
}

/*
 * renvoie la date $d au format jj mois-en-toutes-lettres aaaa en français
 * $d peut être de format string ou DateTime
 */

function dateFrancais($d) {
    if (get_class($d) !== "DateTime") {
        $uneDate = new DateTime($d);
    } else {
        $uneDate = $d;
    }
    $tabMois = array("janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre");
    return $uneDate->format(" d ") . $tabMois[$uneDate->format("m") - 1] . $uneDate->format(" Y ");
}

/* fonctions pour importer un fichier */

function formaterNomFichier($fichier) {
    //On formate le nom du fichier ici...
    $fichier = strtr($fichier, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
    return preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
}

function tailleOk($taille) {
    global $tailleMaxi;
    return $taille <= $tailleMaxi;
}

function creerDossier($dossier) {
    $erreur = "";
    $ilyaerreur = false;
    if (!file_exists($dossier)) {// le répertoire n'existe pas : on va le créer
        if (!mkdir($dossier, 0777, true)) {// erreur de création
            $erreur = "Impossible de créer le répertoire destination.";
            $ilyaerreur = true;
        }
    } elseif (is_file($dossier)) {// un fichier porte le même nom
        $erreur = "Le répertoire de destination existe déjà, mais ce n'est pas un répertoire.";
        $ilyaerreur = true;
    }
    if ($ilyaerreur) {
        return $erreur;
    } else {
        return true;
    }
}

function importerUnFichierImage($fileName, $idFichier, $dossier, $numDest, $dest, $numEleve, $nt, $nc) {
    global $pdo;
    $ilyaerreur = false;
    /* script upload d'après http://antoine-herault.developpez.com/tutoriels/php/upload/ */
    $fichier = basename($fileName);
    $extension = strrchr($fileName, '.');
    $extensions = ['.png', '.gif', '.jpg', '.jpeg']; // création de tableaux nouvelle syntaxe
    $erreur = "Vous devez uploader un fichier de type png, gif, jpg ou jpeg";
    //Début des vérifications de sécurité...
    if (!in_array($extension, $extensions)) { //Si l'extension n'est pas dans le tableau  
        $ilyaerreur = true;
    }
    if (!tailleOk(filesize($idFichier))) {
        $erreur = "Le fichier est trop gros.";
        $ilyaerreur = true;
    }
    $rep = creerDossier($dossier . $dest);
    if (is_string($rep)) {
        $erreur = $rep;
        $ilyaerreur = true;
    }
    if (!$ilyaerreur) { //S'il n'y a pas d'erreur, on enregistre le fichier dans la BD 
            $fichier = formaterNomFichier($fichier);
            //on enregistre le fichier dans la BD
            $numFich = $pdo->setFichier($fichier, $extension, $numDest, $numEleve, $nt, $nc);
            if (false === $numFich) {//erreur lors de l'accès à la BD
            $erreur = "Impossible d'enregistrer le fichier dans la BD";
            $ilyaerreur = true;
        } else {
            $numFich = dec2hex($numFich);
        }
    }
    if (!$ilyaerreur) { //S'il n'y a toujours pas d'erreur, on uploade
        if (move_uploaded_file($idFichier, $dossier . $dest . "/" . $numFich . $extension)) { //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
            $message = $numFich." Fichier : " . $fichier . " : Upload effectué avec succès ! Nouveau nom : " . $dossier . $dest . "/" . $numFich . $extension;
        } else { //Sinon (la fonction renvoie FALSE).
            $message = "00000000 - Fichier : " . $fichier . " : Echec de l'upload !";
        }
    } else {
        $message = "00000000 - Le téléchargement s'est mal passé car : " . $erreur;
    }
    return $message;
}

/* * **** 
 * retourne l'année en cours modifiée par le paramètre $delta
 */

function getYear($delta = 0) {
    $d = getdate();
    $annee = $d['year'] + $delta;
    return $annee;
}

/*
 * retourne la chaine convertit en UTF par défaut. sinon renvoie la chaine initiale
 */

function iso2utf8($str, $isISO = true) {
    if ($isISO)
        return utf8_encode($str);
    return $str;
}

/** converti un entier en hexa sur 8 chiffres
 * 
 * @param type $n
 * @return string de 8 caractères
 */
function dec2hex($n) {
    $num = dechex($n);
    $lim = 8;
    return (strlen($num) >= $lim) ? $num : zeropad("0" . $num, $lim);
}

function zeropad($num, $lim) {
    return (strlen($num) >= $lim) ? $num : zeropad("0" . $num, $lim);
}
