<?php

$lesEleves = $pdo->getLesEleves($_SESSION['nt']);
header("inc/fpdf/tutorial/tuto1.php") ;