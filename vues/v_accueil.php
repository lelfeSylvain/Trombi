Choix du classeur

</nav>


<?php  
if (!empty($_SESSION['nt']) && "inconnu" != $_SESSION['nt']) { ?>


    <p><a href='index.php?uc=upload&num=Mono0'>Charger une image</a></p>
    <p><a href='index.php?uc=upload&num=Multi0&id=<?php echo $numEleve; ?>'>Charger plusieurs images</a></p>
    <p><a href='index.php?uc=import&num=0'>Importer élèves</a></p>
    <p><a href='index.php?uc=afficher&num=0'>voir trombi</a></p>
    <p ><a href='vues/v_genererpdf.php?sens=p' target='_blank' >voir le PDF</a></p>
    <p ><a href='index.php?uc=copier&num=0' >Copier un trombi dans celui en cours</a></p>
    <?php
}
if ("choisir" === $num) {
    include('vues/v_listClasseur.php');
}
   
