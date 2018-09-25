<?php
// importation des valeurs POST
$options = array(
    'default' => null, // valeur à retourner si le filtre échoue
    // autres options ici...
    'min_range' => 0,
    'max_range' => $pdo->getMaxNumClasseur()
);
$etape = filter_input(INPUT_GET, 'e', FILTER_VALIDATE_INT);
$nomNewItem = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING);

// début du traitement
if (0 === $etape) {// gestion de l'affichage du formulaire
    $_SESSION['nc'] = filter_input(INPUT_GET, 'nc', FILTER_VALIDATE_INT, $options);
    
    $lesClasseurs = $pdo->getLesTrombis($_SESSION['numUtil']);
    $etape = 1;
    if ("trombi" === $num) {
        $libnum = "trombinoscope";
        $numClasseurChoisi = $_SESSION['nc'];
    } else {
        $libnum = "classeur";
        $numClasseurChoisi = "nouveau";
        unset($_SESSION['nc']);
    }
    $vueChoisie='v_creer'; 
    $titre="Créer un ".$libnum;
} elseif (1 === $etape) {
    if ('trombi' === $num) {// création du trombi
        $_SESSION['nc'] = filter_input(INPUT_POST, 'nc', FILTER_VALIDATE_INT, $options);
        $_SESSION['nomclasseur'] = $pdo->getNomClasseur($_SESSION['nc']);
        $_SESSION['nt'] = $pdo->setTrombi($_SESSION['nc'], $nomNewItem);
        $_SESSION['nomtrombi'] = $pdo->getNomTrombi($_SESSION['nt'] );
    } elseif ('classeur' === $num) {// création du classeur
        $pdo->setClasseur($_SESSION['numUtil'], $nomNewItem);
        $_SESSION['nc'] = filter_input(INPUT_POST, 'nc', FILTER_VALIDATE_INT, $options);
        $_SESSION['nt'] = "inconnu";
        $_SESSION['nomtrombi'] = "inconnu";
        $_SESSION['nomclasseur'] = $pdo->getNomClasseur($_SESSION['nc']);
    }
    $lesClasseurs = $pdo->getLesTrombis($_SESSION['numUtil']);
    $etape = 0;
    include('controleurs/c_afficher.php');
} else {
    $vueChoisie='v_erreur';
    $titre="Erreur 404";
}
