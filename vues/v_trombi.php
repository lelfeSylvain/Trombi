Afficher un trombi</div></header>
<?php include('vues/v_ariane.php');
echo $message;
?>
<table><tr>    
        <?php
/// affichage du trombi
        $i = 0;$nb=0;
        $numclasse = -1;
        foreach ($lesEleves as $unEleve) {
            if ($numclasse != $unEleve['numclasse']) {
                if (-1!=$numclasse) {echo "<td>".$nb.pluriel($nb," élève")."</td>";}
                echo "</tr><tr><td>" . $unEleve['nomclasse'] . "</td></tr><tr><td>";
                $numclasse = $unEleve['numclasse'];
                $i = 0;$nb=0;
            } else
                echo "<td>";
            ?>
        <a href="index.php?uc=action&num=liberer&e=<?php echo $unEleve['numeleve']; ?>" class='action'>liberer</a>
        <a href="index.php?uc=action&num=supprimer&e=<?php echo $unEleve['numeleve']; ?>" class='action'>supprimer</a>

        <a href="index.php?uc=upload&num=Mono0&e=<?php echo $unEleve['numeleve']; ?>">
            <img title="<?php echo $unEleve['numeleve'] . ' : ' . $unEleve['numfichier'] . ' - ' . dec2hex($unEleve['numfichier']); ?>" src="<?php echo $DOSSIERUPLOAD . $unEleve['path'] . "/" . dec2hex($unEleve['numfichier']) . ".jpg"; ?>" height="200" > 
        </a><p class="petitepolice"><?php
            echo ucwords($unEleve['prenom']) . "<br />" . strtoupper($unEleve['nomeleve']);
            echo "</p></td>";
            $i++;$nb++;
            if (6 < $i) {
                $i = 0;
                echo "</tr><tr>";
            }
        }
        echo "</tr></table>";
        ?>
    <p class='demo'><a href='vues/v_genererpdf.php?sens=P' target='_blank' class='demo'>voir le PDF</a> ou en mode <a href='vues/v_genererpdf.php?sens=L' target='_blank' class='demo'>paysage</a></p>