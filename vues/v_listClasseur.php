<ul>
    <?php
    $numUnClasseur = -1;
    foreach ($lesClasseurs as $unTrombi) {// tant qu'on trouve des classeurs dans le tableau
        if ($numUnClasseur != $unTrombi['numc']) {// c'est un nouveau classeur
            if (-1 != $numUnClasseur) {//mais ce n'est pas le premier classeur
              // on peut créer un nouveau trombi pour le classeur précédent
                echo "<a href='index.php?uc=creer&num=trombi&nc=" . $numUnClasseur . "' title='créer un nouveau trombinoscope'>nouveau trombinoscope</a></li>";
                echo"</ul></li>"; // puis on ferme le classeur précédent 
            }
            // on affiche la nouvelle entrée pour le nouveau classeur
            echo "<li><a href='index.php?uc=accueil&num=choixclasseur&nc=" . $unTrombi['numc']. "' title='choisir ce classeur'>" . $unTrombi['nomc'] . "</a><ul>";
            if (null != $unTrombi['numt']) {//il y a un trombi dans ce classeur
                // on affiche celui-ci
                echo "<li><a href='index.php?uc=accueil&num=choixtrombi&nc=" . $unTrombi['numt'] . "' title='choisir ce trombinoscope'>" .$unTrombi['nomt'] . "</a></li>";
            }
            // on mémorise le n° du nouveau classeur
            $numUnClasseur = $unTrombi['numc'];
        } else {// ce n'est pas un nouveau classeur
            // on affiche que le trombi 
            echo "<li><a href='index.php?uc=accueil&num=choixtrombi&nc=" . $unTrombi['numt'] . "' title='choisir ce trombinoscope'>" . $unTrombi['nomt'] . "</a></li>";
        }
    }
    if (-1 != $numUnClasseur) {// ce n'est pas le premier classeur (il n'y a qu'un classeur)
                echo "<a href='index.php?uc=creer&num=trombi&nc=" . $numUnClasseur . "' title='créer et choisir un nouveau trombinoscope'>nouveau trombinoscope</a></li>";
                echo"</ul></li>";
            }
    ?>
    <li><a href='index.php?uc=creer&num=classeur'  title='créer et choisir un nouveau classeur'>nouveau classeur</a></li>
</ul>

