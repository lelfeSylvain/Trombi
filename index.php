<!DOCTYPE html>
<?php
/* Projet Trombi V1 
  sylvain 25 juillet 2016
 */
$PATH = '';
require_once $PATH . 'inc/fonctions.php'; //appelle tous les 'include' et fonctions utilitaires


/*
 * examinons les paramètres get 
 */
if (!isset($_REQUEST['uc'])) {//s'il n'y a pas d'uc alors on initie le comportement par défaut
    $uc = 'defaut';
    $num = 'actuelle';
} else { // s'il y a un uc, on l'utilise après l'avoir nettoyé
    $uc = filter_input(INPUT_GET, 'uc', FILTER_SANITIZE_STRING);
    if (isset($_REQUEST['num'])) {
        $num = filter_input(INPUT_GET, 'num', FILTER_SANITIZE_STRING);
    } else {// pas de num -> valeur par défaut
        $num = "actuelle";
    }
}
if ($uc === 'login') {
    include('controleurs/c_login.php');
}
// si l'utilisateur n'est pas identifié, il doit le faire
elseif (!Session::isLogged()) {
    $texteNav = "";
    include('vues/v_login.php');
} else {// à partir d'ici, l'utilisateur est forcément connecté
    // justement on enregistre la dernière activité de l'utilisateur dans la BD
    $pdo->setDerniereCx($_SESSION['numUtil']);
//echo $uc.EOL;
    // gère le fil d'ariane : TODO à gérer
    //include_once 'controleurs/c_ariane.php';
    //aiguillage principal
    //echo '########'.$uc;
    include('controleurs/c_accueil.php');
    include('vues/v_ariane.php');

    switch ($uc) {
        case 'action': {// uc gestion des images du trombi
                include("controleurs/c_action.php");
                break;
            }
        case 'afficher': {// uc afficher trombi
                include("controleurs/c_afficher.php");
                break;
            }
        case 'changer': {// uc modification du mot de passe
                include("controleurs/c_changerMDP.php");
                break;
            }
        case 'copier': {// uc copier un trombi dans celui en cours
                include("controleurs/c_copier.php");
                break;
            }
            case 'creer': {// uc création classeur/trombi
                include("controleurs/c_creer.php");
                break;
            }
        case 'creerUtil': {// créer un nouvel utilisateur (seulement SUser)
                include("controleurs/c_creerutil.php");
                break;
            }

        case 'genererpdf': {// uc generer trombi
                include("controleurs/v_genererpdf.php");
                break;
            }

        case 'import': {// uc charger un fichier d"élèves
                include("controleurs/c_import.php");
                break;
            }
        case 'upload': {// uc charger une/des image/s
                include("controleurs/c_upload.php");
                break;
            }
        case 'defaut' :;
        default :  // par défaut 
            include("vues/v_accueil.php");
    }
}

/*
 * une visite a lieu, mémorisons-la
 */
//include('controleurs/c_visite.php');
include('controleurs/c_navigation.php');


