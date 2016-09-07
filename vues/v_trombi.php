Afficher un trombi</div>
<?php include('vues/v_ariane.php'); ?>
<table><tr>    
        <?php
/// affichage du trombi
        $i = 0;
        $numclasse = -1;
        foreach ($lesEleves as $unEleve) {
            if ($numclasse != $unEleve['numclasse']) {
                echo "</tr><tr><td>" . $unEleve['nomclasse'] . "</td></tr><tr><td>";
                $numclasse = $unEleve['numclasse'];
                $i = 0;
            } else
                echo "<td>";
            ?>
        <a href="index.php?uc=action&num=effacer&e=<?php echo $unEleve['numeleve']; ?>">
            <img title="<?php echo $unEleve['numeleve'] . ' : ' . $unEleve['numfichier'] . ' - ' . dec2hex($unEleve['numfichier']); ?>" src="<?php echo $DOSSIERUPLOAD . $unEleve['path'] . "/" . dec2hex($unEleve['numfichier']) . ".jpg"; ?>" height="200" > 
        </a><p class="petitepolice"><?php
            echo ucwords($unEleve['prenom']) . "<br />" . strtoupper($unEleve['nomeleve']);
            echo "</p></td>";
            $i++;
            if (6 < $i) {
                $i = 0;
                echo "</tr><tr>";
            }
        }
        echo "</tr></table>";
        ?>
    <p class='demo'><a href='vues/v_genererpdf.php' target='_blank' class='demo'>voir le PDF</a></p>