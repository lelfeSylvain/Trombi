/*
 * converti le mot de passe saisi en mot de passe crypté
 * dans le formulaire login
 */
function doChallengeResponse() {
    str = "f4G4k2#e33&" + document.identification.password.value;
    document.identification.reponse.value = MD5(str);
    document.identification.mot_de_passe.value = "";

}

/*
 * converti le mot de passe saisi en mot de passe crypté
 * dans le formulaire login
 */
function encodeMDPenMD5() {
    var ancien = document.getElementById('ancien');
    var nouveau = document.getElementById('nouveau');
    var confirmation = document.getElementById('confirmation');
    ancien.value = MD5("f4G4k2#e33&" +ancien.value);
    nouveau.value = MD5("f4G4k2#e33&" +nouveau.value);
    confirmation.value = MD5("f4G4k2#e33&" +confirmation.value);

}
/* calcule la taille des fichiers*/
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
    
    