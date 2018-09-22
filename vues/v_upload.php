Upload</nav>
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
<br><br><br><br><br>
<div class='row'>
    <?php
    $etape = substr($num, -1);
    $typeUpload = substr($num, 0, -1);
    if ('0' === $etape) { //affichage du formulaire 
        ?>
        <div class="offset-sm-3 col-sm-9">
            <form method="POST" action="index.php?uc=upload&num=<?php echo $typeUpload . "1"; ?>" enctype="multipart/form-data">	
                <p>
                    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $tailleMaxi; ?>">
                    <?php if ("Mono" === $typeUpload) { ?> 
                        Fichier : <input id="uploadInput" type="file" name="mesFichiers" onchange="updateSize();">
                        Eleve : <input name="numeleve" type="text" value="<?php echo $numEleve; ?>" >
                    <?php } else { ?>
                        <input id="uploadInput" type="file" name="mesFichiers[]" onchange="updateSize();" multiple> 
                    <?php } ?>
                    selected files: <span id="fileNum">0</span>; 
                    total size: <span id="fileSize">0</span>

                </p>
                <input type="submit" name="envoyer" value="Envoyer le fichier">
            </form> 
        </div>
        <?php
    } else {
        // affichage du résultat des traitements
        $messageUpload = $nb . pluriel($nb, "fichier") . pluriel($nb, " importé") . EOL . $message . EOL;

        //print_r($_FILES['mesFichiers']);
    }
    include 'controleurs/c_afficher.php';
    ?>
</div>
<p><a href='index.php?uc=upload&num=Multi0&id=<?php echo $numEleve; ?>'>Charger plusieurs images</a></p>