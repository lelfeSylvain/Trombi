<?php
// paramètres 

$tailleMaxi = 100000; // On limite le fichier à 100Ko 
$message = "";
$dest = $pdo->getPath($_SESSION['nt']); // le répertoire associé au trombi
$numdest = $pdo->getNumRepertoire($_SESSION['nt']); // le répertoire associé au trombi
if ('Mono0' === $num) {
    $numEleve = $_GET['e']; //TODO filtrer
} else {
    $numEleve = $pdo->getLesNumEleveSansPhoto($_SESSION['nt']);
}
$nb = 0; 


if ('Mono1' === $num) {
    $numEleve = $_POST['numeleve']; //TODO filtrer

    $nb++;
    $message = importerUnFichierImage($_FILES['mesFichiers']['name'], $_FILES['mesFichiers']['tmp_name'], $DOSSIERUPLOAD, $numdest, $dest, $numEleve, $_SESSION['nt'], $_SESSION['nc']);
    $numFichier = hexdec(substr($message, 0, 8));
    if (0 < $numFichier) {
        $pdo->updateEleve($numEleve, $numFichier);
    }
} elseif ('Multi1' === $num) {// tout un sous-répertoire
    //$message = "Traitement non implémenté";
    foreach ($_FILES["mesFichiers"]["error"] as $key => $error) {
        if (UPLOAD_ERR_OK == $error) {
            $msg = importerUnFichierImage($_FILES['mesFichiers']['name'][$key], $_FILES['mesFichiers']['tmp_name'][$key], $DOSSIERUPLOAD, $numdest, $dest, $numEleve[$nb]['n'], $_SESSION['nt'], $_SESSION['nc']) . EOL;
            $numFichier = hexdec(substr($msg, 0, 8));
            $message .= $msg;
            if (0 < $numFichier) {
                $pdo->updateEleve($numEleve[$nb]['n'], $numFichier);
            }
        }
        $nb++;
    }
}
include('vues/v_upload.php');
