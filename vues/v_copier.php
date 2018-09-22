Copier un trombi </nav>
<br><br>
<form method="post" class="form-horizontal" action="index.php?uc=copier&num=1">
    <fieldset>

        <!-- Form Name -->
        <legend>Choisir un classeur à recopier</legend>

        <!-- Select Basic -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="selectbasic">nom du trombi à copier :</label>
            <div class="col-md-4">
                <select id="numtrombichoisi" name="numtrombichoisi" class="form-control">
                    <?php
                    foreach ($lesTrombis as $value) {
                        if ($value['numt'] !== $_SESSION['nt']) {
                            ?>
                            <option value="<?php echo $value['numt']; ?>"><?php echo  $value['nomc'].' - '.$value['nomt']; ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <input type="hidden" name="nc" value="<?php echo $_SESSION['nc'] . '-' . $_SESSION['nt']; ?>">
        <!-- Button -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="singlebutton"></label>
            <div class="col-md-4">
                <button id="singlebutton" name="singlebutton" class="btn btn-primary">Copier</button>
            </div>
        </div>

    </fieldset>
</form>

<?php


