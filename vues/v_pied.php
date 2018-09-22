               
<footer  class="offset-2 navbar fixed-bottom navbar-expand-sm navbar-dark bg-dark">
    <nav class=' '>
        <ul class='list-inline '>
            <li class='list-inline-item'><?php echo $texteNav ;?></li>
            <li class='list-inline-item'><?php echo $_GLOBAL['titre'] ;?></li>
            <li class='list-inline-item'><?php echo "v0.0.2 alpha" ;?></li>
            <li class='list-inline-item'><?php echo "<a href='http://etablissementbertrandeborn.net/'>Site de BdeB</a>" ;?></li>
            <li class='list-inline-item'><?php echo "<img src='https://licensebuttons.net/l/by-nc-sa/3.0/80x15.png' alt='cc-by-nc-sa' />" ;?></li>
            
        </ul>
    </nav>    
    <?php
    if (isset($_SESSION['pseudo']) && $_SESSION['pseudo'] === "debug" && $_SESSION['debug'] === "text") {
        phpinfo();
    }
    ?>

</footer>

</body>
</html>
