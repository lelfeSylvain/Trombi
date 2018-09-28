

<?php

function getOption() {
    $retour = "<ul>
        <li data-jstree='{\"icon\":\"fa %export%\"}'><a href='index.php?uc=action&num=exporter'>Exporter le Trombi</a></li>
        <li data-jstree='{\"icon\":\"fa %upload%\"}'><a href='index.php?uc=upload&num=Multi0&id=inutile'>Charger plusieurs images</a></li>
        <li data-jstree='{\"icon\":\"fa %uploadtxt%\"}'><a href='index.php?uc=import&num=0'>Importer élèves</a></li>
        <li data-jstree='{\"icon\":\"fa %afficher%\", \"selected\" : true }'><a href='index.php?uc=afficher&num=0'>Voir trombi</a></li>
        <li data-jstree='{\"icon\":\"fa %pdf%\"}' >Voir le PDF
            <ul class=' ' >
                <li data-jstree='{\"icon\":\"fa %pdf%\"}' ><a href='vues/v_genererpdf.php?sens=P' target='_blank'  >Portrait</a></li>
                <li data-jstree='{\"icon\":\"fa %pdf%\"}'><a href='vues/v_genererpdf.php?sens=L' target='_blank'  >Paysage</a></li>
            </ul>
        </li>
    </ul>";
    $retour = str_ireplace(['%export%', "%upload%", "%uploadtxt%", "%afficher%", '%pdf%'], ["fa-file-download", "fa-user-friends", "fa-file-upload", "fa-users", "fa-file-pdf"], $retour);
    return $retour;
}

function getFeuille($num, $nom) {// numéro et nom trombi
    $selected = false;
    $style = '{"icon":"fa fa-users"';
    $style = " data-jstree='" . $style;
    if ($num === $_SESSION['nt']) {
        $selected = true;
    }
    $style.="}'";
    $retour = "<li " . $style . "><a href='index.php?uc=accueil&num=choixtrombi&nc="
            . $num . "' title='choisir ce trombinoscope'>" . $nom . "</a>" . EL;
    if ($selected)
        $retour.= getOption() . "</li>" . EL;
    return $retour;
}

function getClasseur($numClasseur, $nomClasseur) {
    $style = '{"icon":"fa fa-folder';
    $style = " data-jstree='" . $style;
    if ($numClasseur === $_SESSION['nc'])
        $style.="-open";
    $style.='"';
    $style.="}'";
    return "<li " . $style . " class=''><a href='index.php?uc=accueil&num=choixclasseur&nc="
            . $numClasseur . "' title='choisir ce classeur'>" . $nomClasseur
            . "</a>\n<ul class=''>" . EL;
}

function getNouveauTrombi($numClasseur) {
    $style = '{"icon":"fa fa-file"}';
    $style = " data-jstree='" . $style . "' ";
    return "<li " . $style . "><a  class='' href='index.php?uc=creer&num=trombi&e=0&nc=" . $numClasseur
            . "' title='créer un nouveau trombinoscope'>nouveau trombinoscope</a></li>" . EL;
}

function getNouveauClasseur() {
    $style = '{"icon":"fa fa-folder-plus"}';
    $style = " data-jstree='" . $style . "' ";
    return "<li " . $style . "><a  class='' href='index.php?uc=creer&num=classeur&e=0'  title='créer et choisir un nouveau classeur'>nouveau classeur</a></li>";
}

$numUnClasseur = -1;

foreach ($lesClasseurs as $unTrombi) {// tant qu'on trouve des classeurs dans le tableau
    if ($numUnClasseur != $unTrombi['numc']) {// c'est un nouveau classeur
        if (-1 != $numUnClasseur) {//mais ce n'est pas le premier classeur
// on peut créer un nouveau trombi pour le classeur précédent
            echo getNouveauTrombi($numUnClasseur);
            echo"</ul></li>" . EL; // puis on ferme le classeur précédent 
        }
// on affiche la nouvelle entrée pour le  classeur suivant
        echo getClasseur($unTrombi['numc'], $unTrombi['nomc']);
        if (null != $unTrombi['numt']) {//il y a un trombi dans ce classeur
// on affiche celui-ci
            if ($_SESSION['nc']===$unTrombi['numc']) {// est-ce que ce classeur est le sélectionné ? 
                // si oui est-ce qu'il existe un trombi sélectionné ? 
                if ($_SESSION['nt'] === "inconnu") {// si non, c'est celui-ci
                    memoriserClasseurTrombi($unTrombi['numt'],"choixtrombi", $pdo);
                    include ('controleurs/c_afficher.php'); // petite entorse au MVC pour charger en mémoire le trombi choisi          
                }                
            }
            echo getFeuille($unTrombi['numt'], $unTrombi['nomt']);
        }
// on mémorise le n° du nouveau classeur
        $numUnClasseur = $unTrombi['numc'];
    } else {// ce n'est pas un nouveau classeur
// on affiche que le trombi 
        echo getFeuille($unTrombi['numt'], $unTrombi['nomt']);
    }
}
if (-1 != $numUnClasseur) {// ce n'est pas le premier classeur (il n'y a qu'un classeur)
    echo getNouveauTrombi($numUnClasseur);
    echo"</ul></li>" . EL;
}
echo getNouveauClasseur();
?>

