<?php

function importerUnFichierCSV($fileName, $idFichier) {
    global $DOSSIERUPLOAD;
    $ilyaerreur = false;
    $dossier = $DOSSIERUPLOAD . dec2hex($_SESSION['nc']) . "/csv";
    /* script upload d'après http://antoine-herault.developpez.com/tutoriels/php/upload/ */
    $fichier = basename($fileName);
    $extension = strrchr($fileName, '.');
    $extensions = ['.txt', '.csv', '.text']; // création de tableaux nouvelle syntaxe
    $erreur = "Vous devez uploader un fichier de type txt, csv ou text.";
    if (!in_array($extension, $extensions)) { //Si l'extension n'est pas dans le tableau  
        $ilyaerreur = true;
    }
    if (!tailleOk(filesize($idFichier))) {
        $erreur = "Le fichier est trop gros.";
        $ilyaerreur = true;
    }
    $rep = creerDossier($dossier);
    if (is_string($rep)) {
        $erreur = $rep;
        $ilyaerreur = true;
    }
    $d = date("Ymd") . ".txt";
    if (!$ilyaerreur) { //S'il n'y a pas d'erreur, on uploade
        if (move_uploaded_file($idFichier, $dossier . "/" . $d)) { //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
            $message = "Fichier : " . $fichier . " : Upload effectué avec succès ! Nouveau nom : " . $dossier . "/" . $d;
        } else { //Sinon (la fonction renvoie FALSE).
            $message = "Fichier : " . $fichier . " : Echec de l'upload !";
        }
    } else {
        $message = "Le téléchargement s'est mal passé car : " . $erreur;
    }
    return $message;
}

// paramètres 

$tailleMaxi = 100000; // On limite le fichier à 100Ko 
$message = "";
$dest = "csv";
$estEnISO8859 = true; // TODO vérifier que le fichier est en iso8859

if ('1' === $num) {
    // pas d'enregistrement dans la BD donc dernier paramètre à false
    $message = importerUnFichierCSV($_FILES['mesFichiers']['name'], $_FILES['mesFichiers']['tmp_name']);
    $options = array(
        'default' => getYear(), // valeur à retourner si le filtre échoue
        // autres options ici...
        'min_range' => getYear(-10),
        'max_range' => getYear(10)
    );
    $annee = filter_input(INPUT_POST, 'annee', FILTER_VALIDATE_INT, $options);
    $message .= EOL . "année : " . $annee . EOL;
    /* lecture du fichier csv */
    $nbligne = 0;
    $handle = @fopen("upload/txt/csv.txt", "r");
    if ($handle) {
        while (($buffer = fgets($handle, 4096)) !== false) {
            //$message .=  iso2utf8 ($buffer, $estEnISO8859).EOL;
            list($nomEle, $prenomEle, $classeEle) = explode(',', iso2utf8($buffer, $estEnISO8859));
            $numClasse = $pdo->setClasseIfNotExist($classeEle, $annee);
            $numEleve = $pdo->setEleveIfNotExist($nomEle, $prenomEle, $numClasse);
            $nbligne++;
        }
        if (!feof($handle)) {
            $message .= "Erreur: fgets() a échoué" . EOL;
        }
        fclose($handle);
        $message .= $nbligne . " lignes importées";
    }
} /* elseif ('Multi1' === $num) {// tout un sous-répertoire
  //$message = "Traitement non implémenté";
  foreach ($_FILES["mesFichiers"]["error"] as $key => $error) {
  if (UPLOAD_ERR_OK == $error) {
  $message .= importerUnFichier($_FILES['mesFichiers']['name'][$key], $_FILES['mesFichiers']['tmp_name'][$key], $dossier, $dest, $numEleve).EOL;
  }
  }
  } */
include('vues/v_import.php');
