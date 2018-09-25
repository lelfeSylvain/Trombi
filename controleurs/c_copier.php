<?php

// importation des valeurs POST
$options = array(
    'default' => null, // valeur à retourner si le filtre échoue
// autres options ici...
    'min_range' => 0,
    'max_range' => $pdo->getMaxNumTrombi()
);



// début du traitement
if ('0' === $num) {// gestion de l'affichage du formulaire
    $lesTrombis = $pdo->getLesTrombis($_SESSION['numUtil']);
    $vueChoisie='v_copier';
    $titre="Copier un trombinoscope";
} elseif ('1' === $num) {
    //var_dump($_POST);
    $numtrombichoisi = filter_input(INPUT_POST, 'numtrombichoisi', FILTER_VALIDATE_INT, $options);
    if ($pdo->copyClasse($numtrombichoisi, $_SESSION['nt'])) {
        if ($pdo->copyEleve($numtrombichoisi, $_SESSION['nt'])) {
            $message = "Copie effectuée";
        } else {
            $message = "Problème lors de la copie des élèves";
        }
    } else {
        $message = "Problème lors de l'insertion des classes";
    }

echo $message;
//$lesClasseurs = $pdo->getLesTrombis($_SESSION['numUtil']);
} else{
    $vueChoisie='v_erreur';
    $titre="Erreur 404";
}
