<?php

$lesEleves = $pdo->getLesElevesOption($_SESSION['nt']);
include 'vues/v_trombi.php';