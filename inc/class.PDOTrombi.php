<?php

include_once $PATH . 'inc/class.MakeLog.php';

/**
 * Modèle du projet : permet d'accéder aux données de la BD
 * La classe est munie d'un outil pour logger les requêtes
 *
 * @author sylvain
 * @date janvier-février 2016
 */
class PDOTrombi {

    // paramètres d'accès au SGBD
    private static $serveur = 'mysql:host=localhost';
    private static $bdd = 'dbname=trombi';
    private static $user = 'trombi';
    private static $mdp = 'trombi';
    // préfixe de toutes les tables
    public static $prefixe = 'trombi_';
    // classe technique permettant d'accéder au SGBD
    private static $monPdo;
    // pointeur sur moi-même (pattern singleton)
    private static $moi = null;
    // active l'enregistrement des logs
    private $modeDebug = true;
    private $monLog;

    /**
     * Constructeur privé, crée l'instance de PDO qui sera sollicitée
     * pour toutes les méthodes de la classe
     */
    private function __construct($path) {
        PDOTrombi::$monPdo = new PDO(PDOTrombi::$serveur . ';' . PDOTrombi::$bdd, PDOTrombi::$user, PDOTrombi::$mdp);
        PDOTrombi::$monPdo->query("SET CHARACTER SET utf8");
        // initialise le fichier log
        $this->monLog = new MakeLog("erreurSQL", $path . "./log/", MakeLog::WRITE);
    }

    public function __destruct() {
        PDOTrombi::$monPdo = null;
    }

    /**
     * Fonction statique qui crée l'unique instance de la classe
     * Appel : $instancePdoTrombi = PdoTrombi::getPdoTrombi();
     * @return l'unique objet de la classe PdoTrombi
     */
    public static function getPDOTrombi($path) {
        if (PDOTrombi::$moi == null) {
            PDOTrombi::$moi = new PDOTrombi($path);
        }
        return PDOTrombi::$moi;
    }

    // enregistre la dernière requête faite dans un fichier log
    private function logSQL($sql) {
        if ($this->modeDebug) {
            $this->monLog->ajouterLog($sql);
        }
    }

    /** renvoie les informations sur un utilisateur dont le pseudo est passé en paramètre
     * 
     * @param type $name : pseudo de l'utilisateur
     * @return type toutes les informations sur un utilisateur
     */
    public function getInfoUtil($name) {
        //$sql="select num, pseudo,  mdp,  tsDerniereCx from ".PdoTrombi::$prefixe."user where pseudo='".$name."'";
        $sql = "select num, pseudo,  mdp,  tsDerniereCx from " . PDOTrombi::$prefixe . "user where pseudo= ?";
        $sth = PDOTrombi::$monPdo->prepare($sql);
        $sth->execute(array($name));
        $this->logSQL($sql);
        //$rs = PdoTrombi::$monPdo->query($sql);

        $ligne = $sth->fetch();
        return $ligne;
    }

    /** met à jour la dernière connexion/activité d'un utilisateur
     * 
     * @param type $num : id de l'utilisateur
     */
    public function setDerniereCx($num) {
        $date = new DateTime();
        //$sql="update ".PdoTrombi::$prefixe."util set tsDerniereCx ='".$date->format('Y-m-d H:i:s')."' where num=".$num;
        $sql = "update " . PdoTrombi::$prefixe . "util set tsDerniereCx = ? where num= ?";
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute(array($date->format('Y-m-d H:i:s'), $num));
        $this->logSQL($sql);
        //$rs =  PdoTrombi::$monPdo->exec($sql);
    }

    /** insère un nouvel utilisateur dans la base
     * 
     */
    // TODO : Pour le moment, on ajoute que le pseudo et le mdp
    // il faut aussi enregistrer les autres propriétés
    public function setNouveauUtil($pseudo, $mdp) {
        $sql = "insert into " . PdoTrombi::$prefixe . "util (pseudo, mdp) values ('" . $pseudo . "','" . $mdp . "')";
        $this->logSQL($sql);
        $sql = "insert into " . PdoTrombi::$prefixe . "util (pseudo, mdp) values (?,?)";
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute(array($pseudo, $mdp));
        return $sth;
    }

    /*
     * récupère le nombre de connexion pour le jour en cours
     */

    public function getNbConnexionDuJour() {
        $jour = new DateTime();
        $sql = "SELECT nb FROM " . PdoTrombi::$prefixe . "log WHERE jour='" . $jour->format('Y-m-d') . "'";
        $this->logSQL($sql);
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute();
        $result = $sth->fetch();
        return $result['nb'];
    }

    /*
     * Ajoute une journée dans les logs de la BD
     */

    public function setPremiereConnexion() {
        $jour = new DateTime();
        $sql = "INSERT INTO " . PdoTrombi::$prefixe . "log (jour,nb) VALUES ('" . $jour->format('Y-m-d') . "', '0')";
        $this->logSQL($sql);
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute();
        return $sth;
    }

    /*
     * compte le nombre d'IP $ip présent dans les logs (en principe 1 ou 0)
     */

    public function getNbIP($ip) {
        $sql = "SELECT COUNT(*) AS nb FROM " . PdoTrombi::$prefixe . "connexions WHERE ip='" . $ip . "'";
        $this->logSQL($sql);
        $sql = "SELECT COUNT(*) AS nb FROM " . PdoTrombi::$prefixe . "connexions WHERE ip=?";
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute(array($ip));
        $result = $sth->fetch();
        $this->logSQL($result['nb']);
        return $result['nb'];
    }

    /*
     * ajoute une nouvelle IP dans la table connexions
     */

    public function setNlleIP($ip) {
        if (isset($_SESSION['username'])) {
            $user = $_SESSION['username'];
        } else {
            $user = "";
        }
        $sql = "INSERT INTO " . PdoTrombi::$prefixe . "connexions (ip,time,pseudo) VALUES ('" . $ip . "', " . time() . ",'" . $user . "')";
        $this->logSQL($sql);
        $sql = "INSERT INTO " . PdoTrombi::$prefixe . "connexions (ip,time,pseudo) VALUES (?,?,?)";
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute(array($ip, time(), $user));
        return $sth;
    }

    /*
     * incrémente le nombre de log dans la table log pour aujourd'hui
     */

    public function incLog() {
        $jour = new DateTime();
        $sql = "UPDATE " . PdoTrombi::$prefixe . "log SET nb=nb+1 WHERE jour='" . $jour->format('Y-m-d') . "'";
        $this->logSQL($sql);
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute();
        return $sth;
    }

    /*
     * on met à jour le timestamp de l'IP
     */

    public function updateIP($ip) {
        $sql = "UPDATE " . PdoTrombi::$prefixe . "connexions SET time=" . time() . " WHERE ip='" . $ip . "'";
        $this->logSQL($sql);
        $sql = "UPDATE " . PdoTrombi::$prefixe . "connexions SET time=? WHERE ip=?";
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute(array(time(), $ip));
        return $sth;
    }

    /*
     * efface les connexions plus vieille de 5 min de la table connexions
     */

    public function delOldTS() {
        $timestamp_5min = time() - 300; // 60 * 5 = nombre de secondes écoulées en 5 minutes
        $sql = "DELETE FROM " . PdoTrombi::$prefixe . "connexions WHERE time < " . $timestamp_5min;
        $this->logSQL($sql);
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute();
        return $sth;
    }

    /*
     * renvoie le nombre de visiteurs actuellement connectés
     */

    public function getNbVisiteur() {
        $jour = new DateTime();
        $sql = "SELECT count(*) as nb FROM " . PdoTrombi::$prefixe . "connexions";
        $this->logSQL($sql);
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute();
        $result = $sth->fetch();
        return $result['nb'];
    }

    /*
     * Renvoie la liste des pseudos connectés en ce moment.
     *       */

    public function getLesPseudosConnectes() {
        $sql = "SELECT pseudo  FROM " . PdoTrombi::$prefixe . "connexions ";
        $this->logSQL($sql);
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll();
        return $result;
    }

    public function getMaxConnexion() {
        $sql = "SELECT max(nb) as nbmax FROM " . PdoTrombi::$prefixe . "log ";
        $this->logSQL($sql);
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute();
        $result = $sth->fetch();
        return $result["nbmax"];
    }

    public function getJourConnexion($jour) {
        $sql = "SELECT jour FROM " . PdoTrombi::$prefixe . "log WHERE nb = ? order by 1 desc ";
        $this->logSQL($sql);
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute(array($jour));
        $result = $sth->fetch();
        return $result["jour"];
    }

    /*
     * Formulaire de changement de mot de passe
     * Vérifie que l'e'ancien mot de passe saisi est le bon
     */

    public function verifierAncienMdP($pseudo, $mdp) {
        $sql = "SELECT count(*) as nb FROM " . PdoTrombi::$prefixe . "user where pseudo= ? and mdp=?";
        $this->logSQL($sql . " " . $pseudo . " " . $mdp);
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute(array($pseudo, $mdp));
        $result = $sth->fetch();
        $this->logSQL($result['nb']);
        return $result['nb'];
    }

    /*
     * Formulaire de changement de mot de passe
     * modifie le mot de passe
     */

    public function setMdP($pseudo, $mdp, $ancien) {
        //$jour = new DateTime();
        $sql = "UPDATE " . PdoTrombi::$prefixe . "user set mdp= ? where pseudo= ? and mdp=?";
        $this->logSQL($sql . $pseudo . " " . $mdp);
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute(array($mdp, $pseudo, $ancien));
        $result = $sth->fetch();
        return $result;
    }

    /** enregistre dans la BD la description du nouveau fichier image
     * 
     * @param string $fichier
     * @param string $extension
     * @param int $dest
     * @param int $numEleve
     * @param int $numt
     * @param int $numc
     * @return boolean ou le numéro du fichier
     */
    public function setFichier($fichier, $extension, $dest, $numEleve, $numt, $numc) {
        $sql = "INSERT INTO " . PdoTrombi::$prefixe . "fichier (nom,suffixe,numrepertoire,numeleve,numtrombi,numclasseur) VALUES ('" . $fichier . "', '" . $extension . "','" . $dest . "','" . $numEleve . "','" . $numt . "','" . $numc . "')";
        $this->logSQL($sql);
        $sql = "INSERT INTO " . PdoTrombi::$prefixe . "fichier (nom,suffixe,numrepertoire,numeleve,numtrombi,numclasseur) VALUES (?,?,?,?,?,?)";
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute(array($fichier, $extension, $dest, $numEleve, $numt, $numc));
        if ($sth) {
            $retour = PdoTrombi::$monPdo->lastInsertId();
        } else {
            $retour = false;
        }
        return $retour;
    }

    /** récupère tous les informations d'un fichier
     * 
     * 
     */
    public function getFichier($numfile) {
        $sql = "SELECT f.num as numfichier, f.nom as nomfichier, r.nom as nomrepertoire, suffixe FROM " . PdoTrombi::$prefixe . "fichier f join " . PdoTrombi::$prefixe . "repertoire r on f.numrepertoire = r.num where f.num= ? ";
        $this->logSQL($sql . " " . $numfile);
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute(array($numfile));
        $result = $sth->fetch();
        $this->logSQL($result['numfichier'] . ', ' . $result['nomfichier'] . ', ' . $result['nomrepertoire']);
        return $result;
    }

    /** efface de la BD le fichier $numfile
     * 
     * @param int $numfile
     * @return type
     */
    public function deleteFichier($numfile) {
        $sql = "DELETE " . PdoTrombi::$prefixe . "fichier where num=?";
        $this->logSQL($sql . " " . $numfile);
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute(array($numfile));
    }

    /**
     * ajoute une classe dans la BD
     * @param type $classe
     * @param type $nt
     * @return le num de la classe ou false
     */
    public function setClasse($classe, $nt) {
        $sql = "INSERT INTO " . PdoTrombi::$prefixe . "classe (nom,numtrombi) VALUES ('" . $classe . "', " . $nt . "')";
        $this->logSQL($sql);
        $sql = "INSERT INTO " . PdoTrombi::$prefixe . "classe (nom,numtrombi) VALUES (?,?)";
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute(array($classe, $nt));
        if ($sth) {
            $retour = PdoTrombi::$monPdo->lastInsertId();
        } else {
            $retour = false;
        }
        return $retour;
    }

    /**
     * Ajoute une nouvelle classe scolaire dans la BD si elle n'existe pas déjà
     * @param type $classe
     * @param type $annee
     * @return type : le n°de la classe.
     */
    public function setClasseIfNotExist($classe, $nt) {
        $code = false;
        $sql = "SELECT num FROM " . PdoTrombi::$prefixe . "classe where nom= ? and numtrombi=?";
        $this->logSQL($sql . " " . $classe . " " . $nt);
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute(array($classe, $nt));
        $result = $sth->fetch();
        if (false === $result) {// s'il n'y a pas de résultats
            $code = $this->setClasse($classe, $nt);
        } else {
            $code = $result['num'];
            $this->logSQL($code);
        }
        return $code;
    }

    /**
     * ajoute un eleve dans la BD
     * 
     * @param type $nom
     * @param type $prenom
     * @param type $classe
     * @return le num de l'élève ou false 
     */
    public function setEleve($nom, $prenom, $classe) {
        $sql = "INSERT INTO " . PdoTrombi::$prefixe . "eleve (nom,prenom,numclasse) VALUES ('" . $nom . "', '" . $prenom . "', '" . $classe . "')";
        $this->logSQL($sql);
        $sql = "INSERT INTO " . PdoTrombi::$prefixe . "eleve (nom,prenom,numclasse) VALUES (?,?,?)";
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute(array($nom, $prenom, $classe));
        if ($sth) {
            $retour = PdoTrombi::$monPdo->lastInsertId();
        } else {
            $retour = false;
        }
        return $retour;
    }

    /**
     * Ajoute un nouvel élève dans la BD s'il n'existe pas déjà
     * 
     * @param type $nom
     * @param type $prenom
     * @param type $classe
     * @return type le n° de l'élève
     */
    public function setEleveIfNotExist($nom, $prenom, $classe) {
        $code = false;
        $sql = "SELECT num FROM " . PdoTrombi::$prefixe . "classe where nom= ? and prenom=? and numclasse=?";
        $this->logSQL($sql . " " . $nom . " " . $prenom . " " . $classe);
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute(array($nom, $prenom, $classe));
        $result = $sth->fetch();
        if (false === $result) {// s'il n'y a pas de résultats
            $code = $this->setEleve($nom, $prenom, $classe);
        } else {
            $code = $result['num'];
            $this->logSQL($code);
        }
        return $code;
    }

    public function getMaxNumEleve() {
        $sql = "SELECT max(num) as nummax FROM " . PdoTrombi::$prefixe . "eleve  ";
        $this->logSQL($sql);
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute(array());
        $result = $sth->fetch();
        return $result['nummax'];
    }

    /**
     * renvoie les trombi créés par l'utilisateur, trié par classeur et par trombi alphabétiquement
     * @param int $numUser
     * @return tableaux résultat de la requête
     */
    public function getLesTrombis($numUser) {
        $sql = "SELECT c.num as numc, c.nom as nomc, c.ts as tsc, t.num as numt, t.nom as nomt, t.ts as tst FROM " . PdoTrombi::$prefixe . "classeur c left join " . PdoTrombi::$prefixe . "trombi t on numclasseur=c.num   where numuser= ? order by 2,5";
        $this->logSQL($sql . " " . $numUser);
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute(array($numUser));
        $result = $sth->fetchAll();
        return $result;
    }

    /**
     * créer un nouveau classeur
     * @param int $numUser
     * @param string $nom
     * @return boolean ou int du nouveau classeur
     */
    public function setClasseur($numUser, $nom) {
        $sql = "INSERT INTO " . PdoTrombi::$prefixe . "classeur (nom,numuser) VALUES (?,?)";
        $this->logSQL($sql . " " . $nom . " " . $numUser);
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute(array($nom, $numUser));
        if ($sth) {
            $retour = PdoTrombi::$monPdo->lastInsertId();
        } else {
            $retour = false;
        }
        return $retour;
    }

    /**
     * creer un nouveau trombi et son répertoire
     * @param int $numClasseur
     * @param string $nom
     * @return boolean ou int du nouveau trombi
     */
    public function setTrombi($numClasseur, $nom) {
        $numRep = $this->setRep();
        if (false === $numRep) {
            return false;
        }
        $sql = "INSERT INTO " . PdoTrombi::$prefixe . "trombi (nom,numclasseur,numrepertoire) VALUES (?,?,?)";
        $this->logSQL($sql . " " . $nom . " " . $numClasseur . " " . $numRep);
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute(array($nom, $numClasseur, $numRep));
        if ($sth) {
            $retour = PdoTrombi::$monPdo->lastInsertId();
            $this->updateRep($numRep, dec2hex($numClasseur) . '/' . dec2hex($retour));
        } else {
            $retour = false;
        }
        return $retour;
    }

    public function getRep($numRep) {
        $sql = "SELECT nom FROM " . PdoTrombi::$prefixe . "repertoire where num= ? ";
        $this->logSQL($sql . " " . $numRep);
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute(array($numRep));
        $result = $sth->fetch();
        return $result;
    }

    /** crée un répertoire vierge
     * 
     * @return boolean ou int
     */
    private function setRep() {
        $sql = "INSERT INTO " . PdoTrombi::$prefixe . "repertoire (nom) VALUES (?)";
        $this->logSQL($sql);
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute(array("new"));
        if ($sth) {
            $retour = PdoTrombi::$monPdo->lastInsertId();
        } else {
            $retour = false;
        }
        return $retour;
    }

    private function updateRep($numRep, $nomRep) {
        $sql = "UPDATE " . PdoTrombi::$prefixe . "repertoire set nom= ? WHERE num = ?";
        $this->logSQL($sql . " " . $numRep . " " . $nomRep);
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute(array($nomRep, $numRep));
    }

    /** renvoie la valeur maximum des idf du classeur
     * 
     * @return entier
     */
    public function getMaxNumClasseur() {
        $sql = "SELECT max(num) as m FROM " . PdoTrombi::$prefixe . "classeur";
        $this->logSQL($sql);
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute(array());
        $result = $sth->fetch();
        return $result['m'];
    }

    /** renvoie le numéro du classeur du trombi associé
     * 
     * @param int $numt
     * @return int
     */
    public function getNumClasseur($numt) {
        $sql = "SELECT numclasseur FROM " . PdoTrombi::$prefixe . "trombi where num=?";
        $this->logSQL($sql . " " . $numt);
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute(array($numt));
        $result = $sth->fetch();
        return $result['numclasseur'];
    }

    /** renvoie le nom du classeur du numéro associé
     * 
     * @param int $numc
     * @return string
     */
    public function getNomClasseur($numc) {
        $sql = "SELECT nom FROM " . PdoTrombi::$prefixe . "classeur where num=?";
        $this->logSQL($sql . " " . $numc);
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute(array($numc));
        $result = $sth->fetch();
        return $result['nom'];
    }

    /** renvoie le nom du trombi du numéro associé
     * 
     * @param int $numt
     * @return string
     */
    public function getNomTrombi($numt) {
        $sql = "SELECT nom FROM " . PdoTrombi::$prefixe . "trombi where num=?";
        $this->logSQL($sql . " " . $numt);
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute(array($numt));
        $result = $sth->fetch();
        return $result['nom'];
    }

    /** renvoie le chemin d'accès au répertoire du trombi
     * 
     * @param int $numt
     * @return string
     */
    public function getPath($numt) {
        $sql = "SELECT r.nom FROM " . PdoTrombi::$prefixe . "trombi t join " . PdoTrombi::$prefixe . "repertoire r on t.numrepertoire = r.num where t.num=?";
        $this->logSQL($sql . " " . $numt);
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute(array($numt));
        $result = $sth->fetch();
        $this->logSQL("==> " . $result['nom']);
        return $result['nom'];
    }

    /** renvoie le chemin d'accès au répertoire du trombi
     * 
     * @param int $numt
     * @return string
     */
    public function getNumRepertoire($numt) {
        $sql = "SELECT numrepertoire FROM " . PdoTrombi::$prefixe . "trombi  where num=?";
        $this->logSQL($sql . " " . $numt);
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute(array($numt));
        $result = $sth->fetch();
        $this->logSQL("==> " . $result['numrepertoire']);
        return $result['numrepertoire'];
    }

    /** renvoie la fiche de l' eleve dont le n° est passé en paramètre
     * @param int $nume
     * @return tableau associatif décrivant un élève
     */
    public function getEleve($nume) {
        $sql = "SELECT * FROM " . PdoTrombi::$prefixe . "eleve where num=? ";
        $this->logSQL($sql . " " . $nume);
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute(array($nume));
        $result = $sth->fetch();
        return $result;
    }

    public function libererImageEleve($nume) {
        $sql = "UPDATE " . PdoTrombi::$prefixe . "eleve set numfichier= 0 WHERE num = ?";
        $this->logSQL($sql . " " . $nume);
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute(array($nume));
    }

    public function libererFichier($numfile) {
        $sql = "UPDATE " . PdoTrombi::$prefixe . "fichier set numeleve= 0 WHERE num = ?";
        $this->logSQL($sql . " " . $numfile);
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute(array($numfile));
    }

    /** renvoie le numéro identifiant du premier eleve du trombinoscope
     *  qui n'a pas de fichier associé
     * @param int $numt
     * @return int
     */
    public function getNumPremierEleveSansPhoto($numt) {
        $sql = "SELECT min(e.num) as n FROM " . PdoTrombi::$prefixe . "eleve e join " . PdoTrombi::$prefixe . "classe c on e.numclasse = c.num  where numtrombi=? and numfichier=0";
        $this->logSQL($sql . " " . $numt);
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute(array($numt));
        $result = $sth->fetch();
        return $result['n'];
    }

    /** renvoie les numéro identifiant des eleves du trombinoscope
     *  qui n'a pas de fichier associé
     * @param int $numt
     * @return tableau 
     */
    public function getLesNumEleveSansPhoto($numt) {
        $sql = "SELECT e.num as n FROM " . PdoTrombi::$prefixe . "eleve e join " . PdoTrombi::$prefixe . "classe c on e.numclasse = c.num  where numtrombi=? and numfichier=0 order by c.nom, e.nom, e.prenom";
        $this->logSQL($sql . " " . $numt);
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute(array($numt));
        $result = $sth->fetchAll();
        return $result;
    }

    /** renvoie le numéro identifiant du premier eleve du trombinoscope
     *  qui n'a pas de fichier associé
     * @param int $numt
     * @return int
     */
    public function getNumDernierEleve($numt) {
        $sql = "SELECT max(e.num) as n FROM " . PdoTrombi::$prefixe . "eleve e join " . PdoTrombi::$prefixe . "classe c on e.numclasse = c.num  where numtrombi=? and numfichier=0";
        $this->logSQL($sql . " " . $numt);
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute(array($numt));
        $result = $sth->fetch();
        return $result['n'];
    }

    /** ajoute le numéro de fichier à l'élève
     * 
     * @param int $numEleve
     * @param int $numf
     */
    public function updateEleve($numEleve, $numf) {
        $sql = "UPDATE " . PdoTrombi::$prefixe . "eleve set numfichier= ? WHERE num = ?";
        $this->logSQL($sql . " " . $numf . " " . $numEleve);
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute(array($numf, $numEleve));
    }

    /** retourne les élèves d'une classe avec le chemin d'accès au répertoire du fichier de l'élève
     * 
     * @param int $numt
     * @return table résultat
     */
    public function getLesEleves($numt) {
        $sql = "SELECT c.num as numclasse,  e.nom as nomeleve, f.num as numfichier, r.nom as path, c.nom as nomclasse, prenom, e.num as numeleve FROM " . PdoTrombi::$prefixe . "eleve e left join " . PdoTrombi::$prefixe . "fichier f on numfichier=f.num left join " . PdoTrombi::$prefixe . "repertoire r on f.numrepertoire=r.num join " . PdoTrombi::$prefixe . "classe c on e.numclasse=c.num where c.numtrombi= ? order by c.nom,2,6";
        ;
        $this->logSQL($sql . " " . $numt);
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute(array($numt));
        $result = $sth->fetchAll();
        return $result;
    }
    /** retourne le nombre d'élèves maxi par classe d'un trombi
     * 
     * @param int $numt
     * @return int
     */
    public function getNbElevesParClasseMax($numt) {
        $sql= "SELECT count(*) as nb FROM " . PdoTrombi::$prefixe . "eleve e join " . PdoTrombi::$prefixe . "classe c on numclasse=c.num where c.numtrombi= ? group by numclasse having COUNT(*) >= all (select count(*) FROM " . PdoTrombi::$prefixe . "eleve join " . PdoTrombi::$prefixe . "classe on numclasse = " . PdoTrombi::$prefixe . "classe.num where " . PdoTrombi::$prefixe . "classe.numtrombi= ? group by numclasse )";
        
        $this->logSQL($sql . " " . $numt);
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute(array($numt,$numt));
        $result = $sth->fetch();
        $this->logSQL( "==> " . $result['nb']);
        return $result['nb'];
    }
    /** retourne le nombre d'élèves  pour chaque classe d'un trombi
     * 
     * @param int $numt
     * @return array
     */
    public function getNbElevesParClasse($numt) {
        $sql= "SELECT count(*) as nb FROM " . PdoTrombi::$prefixe . "eleve e join " . PdoTrombi::$prefixe . "classe c on numclasse=c.num where c.numtrombi= ? group by numclasse order by c.nom";
        
        $this->logSQL($sql . " " . $numt);
        $sth = PdoTrombi::$monPdo->prepare($sql);
        $sth->execute(array($numt));
        $result = $sth->fetchAll();
        return $result;
    }
    public function setParametres($nt, $p) {
        $this->logSQL("avant la requete");
        $sql = "INSERT INTO " . PdoTrombi::$prefixe . "parametres (numtrombi, titre, orientation, cheminphoto, logo, nbcol, nblig, margeDroite,
            margeGauche,margeBas,hauteurTitre,hauteurEtiquette, margeHEntrePhotos,margeVEntrePhotos,largeurMin,
            largeurMax,largeurMoy,hauteurMin,hauteurMax, hauteurMoy) VALUES (?,?,?, ?,?,?, ?,?,?, ?,?,?, ?,?,?, ?,?,?, ?,?)";
        $s = $sql . " (" . $nt;
        for ($i = 0; $i < 20; $i++) {
            $s.=", " . $p[$i];
        }
        $this->logSQL($s . ")");
        $sth = PdoTrombi::$monPdo->prepare($sql);
        array_unshift($p, $nt);
        $this->logSQL("après unsift");
        $sth->execute($p);
        if ($sth) {
            $retour = PdoTrombi::$monPdo->lastInsertId();
        } else {
            $retour = false;
        }$this->logSQL("après encore " . $retour);
        return $retour;
    }

}
