Choix du classeur</div>

</header>
<?php include('vues/v_ariane.php'); ?>
<?php if ("inconnu" != $_SESSION['nt']) { ?>


    <p><a href='index.php?uc=upload&num=Mono0'>Charger une image</a></p>
    <p><a href='index.php?uc=upload&num=Multi0&id=<?php echo $numEleve; ?>'>Charger plusieurs images</a></p>
    <p><a href='index.php?uc=import&num=0'>Importer élèves</a></p>
    <p><a href='index.php?uc=afficher&num=0'>voir trombi</a></p>
    <p class='demo'><a href='vues/v_genererpdf.php' target='_blank' class='demo'>voir le PDF</a></p>
    <?php
}
if ("choisir" === $num) {
    include('vues/v_listClasseur.php');
}

