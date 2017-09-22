<?php
if ("choix" === substr($num, 0, 5)) {
    $nc = filter_input(INPUT_GET, 'nc', FILTER_SANITIZE_STRING);
    if ("choixtrombi" === $num) {
        $_SESSION['nt'] = $nc;
        $_SESSION['nc'] = $pdo->getNumClasseur($nc);
        $_SESSION['nomtrombi'] = $pdo->getNomTrombi($nc);
        $_SESSION['nomclasseur'] = $pdo->getNomClasseur($_SESSION['nc']);
    } elseif ("choixclasseur" === $num) {
        $_SESSION['nc'] = $nc;
        $_SESSION['nomclasseur'] = $pdo->getNomClasseur($_SESSION['nc']);
        $_SESSION['nt'] = "inconnu";
        $_SESSION['nomtrombi'] = "inconnu";
    }
}

$lesClasseurs = $pdo->getLesTrombis($_SESSION['numUtil']);
$_SESSION['etape'] = 0;

