<?php
/* importer un fichier CSV d'élèves */
?>
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

<?php
$etape = substr($num, -1);
$typeUpload = substr($num, 0, -1);
if ('0' === $etape) { //affichage du formulaire 
    ?>
    <div class="row">
        <div class="col-sm-12">
            <p>Importer un fichier CSV au format nom;prenom;classe</p>
            <form method="POST" action="index.php?uc=import&num=<?php echo $typeUpload . "1"; ?>" enctype="multipart/form-data">	
                <p>
                    Année : <input id="annee" type="number" name="annee" value ='<?php echo getYear(); ?>'>
                </p>
                <p>
                    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $tailleMaxi; ?>">
                    Fichier : <input id="uploadInput" type="file" name="mesFichiers" onchange="updateSize();">
                    selected files: <span id="fileNum">0</span>; 
                    total size: <span id="fileSize">0</span>
                </p>
                <input type="submit" name="envoyer" value="Envoyer le fichier">
            </form> 
            <?php
        } else {
            // affichage du résultat des traitements
            if (!empty($message)) echo $message . EOL;
        }
        ?>
    </div>
</div>
