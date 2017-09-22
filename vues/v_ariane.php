<section class='corps'>
    <section class='colonneGauche' >
        <section class='menuflottant' id='monMenu'>
            <p>Utilisateur : <?php echo $_SESSION['pseudo']; ?>
                <br/> classeur : <?php echo $_SESSION['nomclasseur'], '-', $_SESSION['nomtrombi']; ?>
            </p>
            <ul class="niveau1">
                <li class='plus'>Changer de Trombi
                    <?php
                    include('vues/v_listClasseur.php');
                    ?>
                </li>
                <?php if ("inconnu" != $_SESSION['nt']) { ?>


                    <li ><a href='index.php?uc=action&num=exporter'>Exporter le Trombi</a></li>
                    <li ><a href='index.php?uc=upload&num=Multi0&id=<?php echo $numEleve; ?>'>Charger plusieurs images</a></li>
                    <li ><a href='index.php?uc=import&num=0'>Importer élèves</a></li>
                    <li ><a href='index.php?uc=afficher&num=0'>Voir trombi</a></li>
                    <li class='plus'>Voir le PDF
                        <ul class="niveau2">
                            <li><a href='vues/v_genererpdf.php?sens=P' target='_blank' class='demo'>Portrait</a></li>
                            <li><a href='vues/v_genererpdf.php?sens=L' target='_blank' class='demo'>Paysage</a></li>
                        </ul>
                        <?php
                    }
                    ?>
            </ul>
        </section>
    </section>

    <section class='application'>
