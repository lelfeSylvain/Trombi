<?php

if ("choix" === substr($num, 0, 5)) {
    $nc = filter_input(INPUT_GET, 'nc', FILTER_SANITIZE_STRING);
    memoriserClasseurTrombi($nc, $num, $pdo);
}
// initialisation de l'arbre des trombis
 $lesClasseurs = $pdo->getLesTrombis($_SESSION['numUtil']);

if (!empty($_SESSION['nt']) && "inconnu" != $_SESSION['nt']) {
    include 'controleurs/c_afficher.php';
} else {
   
    $vueChoisie = 'v_accueil';
    $titre = "Accueil";
}