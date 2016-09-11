<?php

// importation des valeurs GET
$options = array(
    'default' => null, // valeur à retourner si le filtre échoue
    // autres options ici...
    'min_range' => 0,
    'max_range' => $pdo->getMaxNumEleve()
);
$numFichierVide = 0;
$message = "pas d'opération" . EOL;
$numEleveATraiter = filter_input(INPUT_GET, 'e', FILTER_VALIDATE_INT, $options);
if ('liberer' === $num) {// on veut libérér la photo de l'élève choisi
    $ficheEleve = $pdo->getEleve($numEleveATraiter); // on récupère les informations de l'élève
    if (0 != $ficheEleve['numfichier']) { // s'il existe unfichier (autre que celui par défaut, le fichier 0)
        $leFich = $pdo->getFichier($ficheEleve['numfichier']); // on récupère les infos du fichier lui-même
        if (null != $leFich) {// si on les obtient (erreur ?  
            // on le libère du ficheir eleve associé dans la BD
            $pdo->libererFichier($leFich['numfichier']) . EOL;
        } else
            $message='pas de suppression ' . EOL;
        // on affecte le fichier 0 (par défaut) à cet élève
        $pdo->libererImageEleve($numEleveATraiter);
    }
}elseif ('supprimer' === $num) {// TODO la suppression ne devrait concerner qu'un fichier libéré
    $ficheEleve = $pdo->getEleve($numEleveATraiter); // on récupère les informations de l'élève
    if (0 != $ficheEleve['numfichier']) { // s'il existe unfichier (autre que celui par défaut, le fichier 0)
        $leFich = $pdo->getFichier($ficheEleve['numfichier']); // on récupère les infos du fichier lui-même
        if (null != $leFich) {// si on les obtient (erreur ?)
            // on efface le fichier du disque
            $message=unlink($DOSSIERUPLOAD . $leFich['nomrepertoire'] . '/' . dec2hex($leFich['numfichier']) . $leFich['suffixe']) . EOL;
            // on efface de la BD
            $pdo->deleteFichier($leFich['numfichier']) . EOL;
        } else
            $message='pas de suppression ' . EOL;
        // on affecte le fichier 0 (par défaut) à cet élève
        $pdo->libererImageEleve($numEleveATraiter);
    }
}elseif ('charger' === $num){
    
}
    $lesEleves = $pdo->getLesEleves($_SESSION['nt']);
include('vues/v_trombi.php');
