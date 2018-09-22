<?php if ('Multi' != substr($num, 0, 5)) { ?> Afficher un trombi
    </nav>
    <br><br><?php } ?>
<section class='col-xs-11 col-sm-10'>
    <div class="row">
        <?php
        if (!empty($message))
            echo $message;
        /*if (!empty($messageUpload))
            echo $messageUpload;*/
        ?>
        <p class='col-sm-12'><a href='vues/v_genererpdf.php?sens=P' target='_blank' class='demo'>voir le PDF</a> ou en mode <a href='vues/v_genererpdf.php?sens=L' target='_blank' class='demo'>paysage</a></p>


        <?php
/// affichage du trombi
        $i = 0;
        $nb = 0;
        $numclasse = -1;
        $nbPhoto = 10; // nombre de photos par ligne
        ?>

        <?php
        foreach ($lesEleves as $unEleve) {
            ?>

            <?php
            if ($numclasse != $unEleve['numclasse']) {// afficher le nom de la classe
                if (-1 != $numclasse) {//    afficher le nombre d'élève
                    echo '<div class="col-sm-12 text-right">' . $nb . pluriel($nb, " élève") . '</div>';
                }
                echo '<div class="col-sm-12 text-left">' . $unEleve['nomclasse'] . '</div>';
                $numclasse = $unEleve['numclasse'];
                $i = 0;
                $nb = 0;
            } else
                
                ?>
            <div class='col-xs-4 col-sm-3 col-md-2 col-lg-1'>
                <div class='row small'>
                    <div class='col-xs-1 col-sm-2'>
                        <a href="index.php?uc=action&num=liberer&e=<?php echo $unEleve['numeleve']; ?>" title='libérer la photo' class='btn-secondary'><span class="fa fa-unlink"></span></a>
                    </div>

                    <div class='col-xs-1 col-sm-2'>
                        <a href="index.php?uc=action&num=supprimer&e=<?php echo $unEleve['numeleve']; ?>" class='btn-secondary' title='supprimer la photo' ><span class="fa fa-user-times"></span></a>
                    </div>


                    <div class='col-xs-1 col-sm-2'>
                        <a href="index.php?uc=action&num=supprimertout&e=<?php echo $unEleve['numeleve']; ?>" class='btn-danger' title='supprimer la personne et la photo' ><span class="fa fa-trash"></span></a>
                    </div>
                    <div class='col-sm-12'>
                        <a href="index.php?uc=upload&num=Mono0&e=<?php echo $unEleve['numeleve']; ?>">
                            <img class='img-fluid' title="<?php echo $unEleve['numeleve'] . ' : ' . $unEleve['numfichier'] . ' - ' . dec2hex($unEleve['numfichier']); ?>" src="<?php if (empty($unEleve['path'])) {$cheminImage=$IMAGEINCONNUE;}else{$cheminImage=$DOSSIERUPLOAD . $unEleve['path'] . "/" . dec2hex($unEleve['numfichier']) . $unEleve['extension'];} echo $cheminImage; ?>"  width="80" > 
                        </a>
                    </div>
                    <div class='col-sm-12 small'>
                        <?php
                        echo ucwords($unEleve['prenom']) . "<br />" . strtoupper(couperNom($unEleve['nomeleve']));
                        if (isset($unEleve['valeur'])) {
                            echo "<br /><i>" . strtoupper(couperNom($unEleve['valeur'])) . "</i>";
                        }
                        ?>
                        <?php
                        $i++;
                        $nb++;
                        if ($nbPhoto <= $i) {
                            $i = 0;
                        }
                        ?>

                    </div>
                </div>
            </div>
            <?php
        }
        echo '<div class="col-sm-12 text-right">' . $nb . pluriel($nb, " élève") . '</div>';
        ?>
    </div>
</section>  