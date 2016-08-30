Créer un <?php echo $libnum; ?></div>

</header>
<?php include('vues/v_ariane.php');?>
<?php include('vues/v_listClasseur.php');?>
<form method="post" action="index.php?uc=creer&num=<?php echo $num; ?>" class="formulaire">

    <div class='formulaireLigneChamp'>
        <p class="palibel2">nom du nouveau <?php echo $libnum; ?> :</p>
        <input type="text" name="nom" value="">
    </div>
    <div class='formulaireLigneChamp'>
         <input type="text" name="nc" value="<?php echo $numClasseurChoisi; ?>">
        <input type="submit" value="Créer le <?php echo $libnum; ?>"  class="boutonConnexion">
    </div>

</form>
<?php


