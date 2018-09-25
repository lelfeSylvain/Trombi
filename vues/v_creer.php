<div class="row">
    <div class="col-sm-8 bg-light">
        <form method="post" action="index.php?uc=creer&num=<?php echo $num; ?>&e=1" class="">

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


