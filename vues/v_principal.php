<?php include 'vues/v_entete.php';  ?>
<body class="bg-light">
    <nav class="navbar navbar-expand-md bg-dark fixed-top navbar-dark">
        <div class="navbar-brand">
            <?php
            echo $_GLOBAL['titre'] . ' - ' . $titre;
            ?>
        </div>
    </nav>
    <br><br><br>
    <div id="wrapper" class="container-fluid">
        <div class='row'>
            <div class="col-xs-1 col-sm-2">
                <?php
                include 'vues/v_ariane.php';
                ?>
            </div>
            <div class='col-xs-11 col-sm-10 '>
                <div class="row">

                    <?php
                    include 'vues/' . $vueChoisie . '.php';
                    ?> 

                    <?php
                    if (isset($_SESSION['pseudo']) && $_SESSION['pseudo'] === "debug" && $_SESSION['debug'] === "text") {
                        phpinfo();
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- jstree JavaScript -->
    <script src="vendor/jstree/jstree.min.js"></script>
    <!-- perso JavaScript -->
    <script language="javascript" src="js/md5.js"></script>
    <script language="javascript" src="js/fonctions.js"></script>
    <script  language="javascript">
        $('#tree')
                .on('ready.jstree',function () {
                    //alert('coucou');
               
                $('#tree').on('changed.jstree', function (e, data) {
                    var i, j, r = [];
                    for (i = 0, j = data.selected.length; i < j; i++) {
                        r.push(data.instance.get_node(data.selected[i]).a_attr.href);
                    }
                    //alert(r[0]);
                    location.href = r[0];
                })
 })

                .jstree();
    </script>
</body>
</html>
