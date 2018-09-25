<?php

$lesEleves = $pdo->getLesElevesOption($_SESSION['nt']);
$vueChoisie='v_trombi';
$titre="Afficher le trombi ".$_SESSION['nomclasseur'].' - '.$_SESSION['nomtrombi'];