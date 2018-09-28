<?php include 'vues/v_entete.php'; ?>
<body class="bg-light">
    <nav class="navbar navbar-expand-md bg-dark fixed-top navbar-dark">
        <div class="navbar-brand">
            <?php
            echo $_GLOBAL['titre'];
            if (!empty($titre))
                echo ' - ' . $titre;
            ?>
        </div>
    </nav>
    <div id="wrapper" class="container-fluid">
        <div class='row'>
            <div class="col-xs-1 col-sm-2 col-md-2 col-lg-2">
                <?php
                include 'vues/v_ariane.php';
                ?>
            </div>
            <div class='col-xs-11 col-sm-10 col-md-10 col-lg-10'>
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
                .on('ready.jstree', function () {
                    //alert('coucou');

                    $('#tree').on('changed.jstree', function (e, data) {
                        var i, j, r = [];
                        for (i = 0, j = data.selected.length; i < j; i++) {
                            r.push(data.instance.get_node(data.selected[i]).a_attr.href);
                        }
                        //alert(r[0]);
                        if ('vues/v_genererpdf.php' === r[0].substring(0, 21)) {
                            ouvrirPopup(r[0]);
                        } else {
                            location.href = r[0];
                        }
                    })
                })

                .jstree();

        $('a.text-danger').click(function (e) {

            var r = confirm("Êtes-vous sur de vouloir effacer définitivement "+this.title.substring(23,this.title.length))+" ?";
            if (true == r) {
                //alert(this.href);// cette ligne ne sert pas
            }
            else
                e.preventDefault(); // annule l'action choisie
            return r;
        })
    </script>
</body>
</html>
