<?php include 'vues/v_entete.php'; ?>
<body class="bg-light">
    <nav class="navbar fixed-top bg-dark navbar-dark flex-md-nowrap p-0">
        <div class="container-fluid flex-md-nowrap">
            <div class="navbar-header  p-0">

                <span class="navbar-brand">
                    <?php
                    echo $_GLOBAL['titre'];
                    if (!empty($titre)) {
                        echo ' - ' . $titre;
                    }
                    ?>
                </span>
            </div>
            <div class="navbar-right ">
                <ul class="nav">
                    <?php
                    if (Session::isLogged()) {
                        ?>
                        <li class="nav-item text-nowrap"><a class="nav-link" href='index.php?uc=accueil&num=in' title="Retourner à l'accueil" >Bienvenue <?php echo $_SESSION['pseudo']; ?></a></li>
                        <li class="nav-item text-nowrap"><a class="nav-link" href='index.php?uc=changerMdP&num=in' title="Changer le mot de passse" ><i class="fas fa-user-cog "></i></a></li>
                        <li class="nav-item text-nowrap"><a class="nav-link" href='index.php?uc=login&num=out' title="Déconnexion" ><i class="fas fa-power-off"></i></a></li>
                    <?php } else { ?>
                    <?php } ?>
                </ul>
            </div>


        </div>
    </nav>
    <div id="wrapper" class="container-fluid">
        <div class='row'>
            <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 pl-0 pr-0">
                <?php
                include 'vues/v_ariane.php';
                ?>
            </div>
            <div class='col-xs-12 col-sm-10 col-md-10 col-lg-10 pl-3 '>
                <div class="row">

                    <?php
                    afficheMessages($texteNav);
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
        /* gestion du treeview */
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

        /* gère la disparition des alertes (cf fonctions.php) */
        $(function () {
            $("#infos .close").click(function () {
                $("#infos .alert").hide("slow");
            });
        });

        /*suppression d'une personne définitivement */
        $('a.text-danger').click(function (e) {
            var r = confirm("Êtes-vous sur de vouloir effacer définitivement " + this.title.substring(23, this.title.length)) + " ?";
            if (TRUE === r) {
                //alert(this.href);// cette ligne ne sert pas
            } else {
                e.preventDefault(); // annule l'action choisie
            }
            return r;
        })

    </script>
</body>
</html>
