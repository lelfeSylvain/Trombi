Créer un <?php echo $libnum; ?> </nav>
<br><br>
<div class="row">
    <div class="offset-2 col-sm-8 bg-dark">
        <form method="post" action="index.php?uc=creer&num=<?php echo $num; ?>" class="">

            <div class='form-group'>
                <label  for="nom">nom du nouveau <?php echo $libnum; ?> :</label>
                <input type="text" name="nom" value="" id="nom" class="form-control form-control-sm">
                <input type="hidden" name="nc" value="<?php echo $numClasseurChoisi; ?>">
                <input type="submit" value="Créer le <?php echo $libnum; ?>"  class="btn btn-primary">
            </div>

        </form>
    </div>
</div>
<?php


