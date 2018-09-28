

<!-- Sidebar -->
<div id="" class='navbar bg-light small sidebar audessus'  >
    <?php if (Session::isLogged()) {
            ?>
    <p class='navbar-text navbar'>
        Utilisateur : <?php echo $_SESSION['pseudo']; ?>
        <br/> classeur :
        <?php
        if (!empty($_SESSION['nomclasseur']) && !empty($_SESSION['nomtrombi']))
            echo $_SESSION['nomclasseur'], '-', $_SESSION['nomtrombi'];
        ?>
    </p>
    <div   id="tree">
        <ul   class="">            
            <?php
            include('vues/v_listClasseur.php');
            ?>
        </ul>
    </div>
    <?php } ?>
    <footer  class="bg-light  enbas">
        
            <ul class='list-inline navbar-text  '>
                <li class='list-inline-item'><?php echo $_GLOBAL['titre']; ?></li>
                <li class='list-inline-item'><?php echo "v1.0.0 alpha"; ?></li>
                <li class='list-inline-item'><?php echo "<img src='https://licensebuttons.net/l/by-nc-sa/3.0/80x15.png' alt='cc-by-nc-sa' />"; ?></li>
                <li class='list-inline-item'><?php echo "<a href='http://etablissementbertrandeborn.net/'>Site de BdeB</a>"; ?></li>
                
            </ul>
        
    </footer>
</div>







