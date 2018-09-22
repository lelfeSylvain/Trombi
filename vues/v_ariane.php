
<div id="wrapper" class="toggled bg-dark ">
    <div class='row'>
        <!-- Sidebar -->
        <div id="sidebar-wrapper" class='navbar navbar-dark bg-dark  col-sm-2 small'  >

            <p class='navbar-text navbar-dark'><br><br>
                Utilisateur : <?php echo $_SESSION['pseudo']; ?>
                <br/> classeur :
                <?php
                if (!empty($_SESSION['nomclasseur']) && !empty($_SESSION['nomtrombi']))
                    echo $_SESSION['nomclasseur'], '-', $_SESSION['nomtrombi'];
                ?>
            </p>
            <ul  id="tree" class=" ">
                <?php if (!empty($_SESSION['nt']) && "inconnu" != $_SESSION['nt']) { ?>
                    <li   class=''><a href='index.php?uc=action&num=exporter'>Exporter le Trombi</a></li>
                    <li   class=''><a href='index.php?uc=upload&num=Multi0&id=<?php echo $numEleve; ?>'>Charger plusieurs images</a></li>
                    <li   class=''><a href='index.php?uc=import&num=0'>Importer élèves</a></li>
                    <li   class=''><a href='index.php?uc=afficher&num=0'>Voir trombi</a></li>
                    <li class='navbar-text' >Voir le PDF
                        <ul class=' ' >
                            <li  class='' ><a href='vues/v_genererpdf.php?sens=P' target='_blank'  >Portrait</a></li>
                            <li  class=''><a href='vues/v_genererpdf.php?sens=L' target='_blank'  >Paysage</a></li>
                        </ul>
                    </li>
                    <?php
                }
                ?>
                <?php
                include('vues/v_listClasseur.php');
                ?>
            </ul>
        </div>
    </div>


    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <?php echo $_GLOBAL['titre']; ?> - 



