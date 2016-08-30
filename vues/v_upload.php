Upload</div>
<script>
    function updateSize() {
        var nBytes = 0,
                oFiles = document.getElementById("uploadInput").files,
                nFiles = oFiles.length;
        for (var nFileId = 0; nFileId < nFiles; nFileId++) {
            nBytes += oFiles[nFileId].size;
        }
        var sOutput = nBytes + " bytes";
        // optional code for multiples approximation
        for (var aMultiples = ["KiB", "MiB", "GiB", "TiB", "PiB", "EiB", "ZiB", "YiB"], nMultiple = 0, nApprox = nBytes / 1024; nApprox > 1; nApprox /= 1024, nMultiple++) {
            sOutput = nApprox.toFixed(3) + " " + aMultiples[nMultiple] + " (" + nBytes + " bytes)";
        }
        // end of optional code
        document.getElementById("fileNum").innerHTML = nFiles;
        document.getElementById("fileSize").innerHTML = sOutput;
    }
    

</script>
</header>
<?php include('vues/v_ariane.php'); ?>
<?php
$etape = substr($num, -1);
$typeUpload = substr($num, 0, -1);
if ('0' === $etape) { //affichage du formulaire 
    ?>

    <form method="POST" action="index.php?uc=upload&num=<?php echo $typeUpload . "1"; ?>" enctype="multipart/form-data">	
        <p>
            <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $tailleMaxi; ?>">
            <?php if ("Mono" === $typeUpload) { ?> 
                Fichier : <input id="uploadInput" type="file" name="mesFichiers" onchange="updateSize();">
            <?php } else { ?>
                <input id="uploadInput" type="file" name="mesFichiers[]" onchange="updateSize();" multiple> 
            <?php } ?>
            selected files: <span id="fileNum">0</span>; 
            total size: <span id="fileSize">0</span>

        </p>
        <input type="submit" name="envoyer" value="Envoyer le fichier">
    </form> 
    <?php
} else {
    // affichage du résultat des traitements
    echo $nb.pluriel($nb,"fichier").pluriel($nb," importé").EOL; 
    echo $message . EOL;
    
   //print_r($_FILES['mesFichiers']);
   
    
}
 include 'controleurs/c_afficher.php'; ?>
    <p><a href='index.php?uc=upload&num=Multi0&id=<?php echo $numEleve;?>'>Charger plusieurs images</a></p>