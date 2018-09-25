<?php

if ("choix" === substr($num, 0, 5)) {
    $nc = filter_input(INPUT_GET, 'nc', FILTER_SANITIZE_STRING);
    memoriserClasseurTrombi($nc,$num,$pdo);
}

$lesClasseurs = $pdo->getLesTrombis($_SESSION['numUtil']);
$vueChoisie='v_accueil';
$titre="Accueil";

