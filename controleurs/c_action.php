<?php

// importation des valeurs GET
$options = array(
    'default' => null, // valeur à retourner si le filtre échoue
    // autres options ici...
    'min_range' => 0,
    'max_range' => $pdo->getMaxNumEleve()
);
$numFichierVide=0;
$numEleveATraiter = filter_input(INPUT_GET, 'e', FILTER_VALIDATE_INT, $options);
if ('effacer===$num') {
    //$pdo->setImage2Eleve($numEleveATraiter,$numFichierVide);
}

