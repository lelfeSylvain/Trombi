<?php

$lesEleves = $pdo->getLesEleves($_SESSION['nt']);
include 'vues/v_trombi.php';