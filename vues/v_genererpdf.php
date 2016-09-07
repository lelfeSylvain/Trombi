<?php

require('../inc/fpdf/fpdf.php');

class PDF extends FPDF {

    private $titre;
    private $lesEleves; //  array contient les données
    private $path;
    private $nbcol;
    private $nblig;
    private $orientation;
    private $largeurPhoto;
    private $margeGauche, $margeDroite, $margeBas, $margeHEntrePhotos, $margeVEntrePhotos;
    private $hauteurPhoto;
    private $hauteurEtiquette;
    private $hauteurTitre;
    private $nbPhotoPage;
    private $utiliseEchelleVerticale;
    private $largeurMin;
    private $largeurMax;
    private $largeurMoy;
    private $hauteurMoy;
    private $hauteurMax;
    private $hauteurMin;
    private $mesParametres;
    private $logo;

    public function __construct($t, $l, $p, $o, $nbc, $nbl,$logo) {
        parent::__construct($o, "mm", "A4");
        
        $this->logo=$logo;
        $this->titre = $t;
        $this->lesEleves = $l;
        $this->path = $p;
        $this->nbcol = $nbc;
        $this->nblig = $nbl;
        $this->orientation = $o;
        $this->margeGauche = 10; // en mm
        $this->margeDroite = 10; // en mm
        $this->margeBas = 15; // en mm
        $this->hauteurEtiquette = 4;
        $this->margeHEntrePhotos = 4; // en mm
        $this->margeVEntrePhotos = $this->hauteurEtiquette * 2; // en mm
        $this->hauteurPhoto = 40; // en mm

        $this->hauteurTitre = 34;
        $this->SetTitle($t);
        $this->SetAutoPageBreak(false);

        // on calcule la largeur idéale d'une photo en prenant la largeur
        //  de la page totale et en enlevant les marges gauche et droite et 
        //  celle entre les photos
        $this->largeurPhoto = ($this->GetPageWidth() - ($this->margeDroite + $this->margeGauche + ($this->nbcol - 1) * $this->margeHEntrePhotos)) / $this->nbcol;
        $this->hauteurPhoto = ($this->GetPageHeight() - ($this->hauteurTitre + $this->margeBas + ($this->nblig ) * $this->margeVEntrePhotos)) / $this->nblig;
        $this->utiliseEchelleVerticale = false;
        // calcule des dimensions moyennes, mini, maxi des photos à afficher
        $this->calculerStatPhotos();
        // si la hauteur moyenne des photos est supérieur à la hauteur calculée, 
        // il vaut mieux cadrer les photos verticalement plutôt qu'horizontalement
        if ($this->hauteurMoy > $this->hauteurPhoto) {
            $this->utiliseEchelleVerticale = true;
            $this->largeurPhoto = $this->largeurMoy;
            $this->margeHEntrePhotos = ($this->GetPageWidth() - ($this->margeDroite + $this->margeGauche + $this->largeurPhoto * $this->nbcol)) / ($this->nbcol - 1);
        } else {
            $this->hauteurPhoto = $this->hauteurMoy;
        }
        $this->mesParametres = new Parametres($t,$nbc, $nbl,$o,$p,$logo,10,10,15,34,4,4,8,$this->largeurMin,$this->largeurMax,
                $this->largeurMoy,$this->hauteurMin, $this->hauteurMax, $this->hauteurMoy);
    }
    function getParametres() {
        $p= [ $this->mesParametres->getTitre(),
            $this->mesParametres->getOrientation(),
            $this->mesParametres->getPath(),
            $this->mesParametres->getLogo(),
            $this->mesParametres->getNbcol(),
            $this->mesParametres->getNblig(),
            $this->mesParametres->getMargeDroite(),
            $this->mesParametres->getMargeGauche(),
            $this->mesParametres->getMargeBas(),
            $this->mesParametres->getHauteurTitre(),
            $this->mesParametres->getHauteurEtiquette(),
            $this->mesParametres->getMargeHEntrePhotos(),
            $this->mesParametres->getMargeVEntrePhotos(),
            $this->mesParametres->getLargeurMin(),
            $this->mesParametres->getLargeurMax(),
            $this->mesParametres->getLargeurMoy(),
            $this->mesParametres->getHauteurMin(),
            $this->mesParametres->getHauteurMax(),
            $this->mesParametres->getHauteurMoy()
            ];
        return $p;
    }

        function calculerStatPhotos() {
        $hmax = -1;
        $vmax = -1;
        $hmin = $this->GetPageHeight();
        $vmin = $this->GetPageWidth();
        $hmoy = 0;
        $vmoy = 0;
        $i = 0;
        foreach ($this->lesEleves as $unEleve) {
            $chemin = $this->path . $unEleve['path'] . "/" . dec2hex($unEleve['numfichier']) . ".jpg";
            $ratio = $this->ratioH($chemin);
            $hauteur = $ratio * $this->largeurPhoto;
            $largeur = (1 / $ratio) * $this->hauteurPhoto;
            if ($hauteur > $hmax) {
                $hmax = $hauteur;
            }
            if ($hauteur < $hmin) {
                $hmin = $hauteur;
            }
            if ($largeur > $vmax) {
                $vmax = $largeur;
            }
            if ($largeur < $vmin) {
                $vmin = $largeur;
            }
            $hmoy += $hauteur;
            $vmoy += $largeur;
            $i++;
        }
        $this->largeurMoy = $vmoy / $i;
        $this->hauteurMoy = $hmoy / $i;
        $this->hauteurMax = $hmax;
        $this->hauteurMin = $hmin;
        $this->largeurMax = $vmax;
        $this->largeurMin = $vmin;
    }

    private function size($chemin) {
        list($width, $height, $type, $attr) = getimagesize($chemin);
        return $width . " x " . $height . " px";
    }

    private function ratioH($chemin) {
        list($width, $height, $type, $attr) = getimagesize($chemin);
        return $height / $width;
    }

    private function ratioV($chemin) {
        return 1 / $this->ratioH($chemin);
    }

// Composition du Trombinoscope
    function ComposerTrombinoscope() {
        $numclasse = -1;
        foreach ($this->lesEleves as $unEleve) {
            if ($numclasse != $unEleve['numclasse']) {// on change de page
                $this->AddPage();
                $x = $this->margeGauche;
                $y = $this->hauteurTitre;
                // on place le titre de la page
                $this->affiche(0, 20, $unEleve['nomclasse'], true, 15, true);
                // on se souvient de la classe actuelle
                $numclasse = $unEleve['numclasse'];
                $i = 0;
                $j = 0;
                $this->nbPhotoPage = 0;
            }
            $this->setImage($x, $y, $this->path . $unEleve['path'] . "/" . dec2hex($unEleve['numfichier']) . ".jpg");

            $this->affiche($x, $y + $this->hauteurPhoto, ucwords($unEleve['prenom']));
            //$this->affiche($x, $y + 30, $this->largeurPhoto*$this->ratio($this->path . $unEleve['path'] . "/" . dec2hex($unEleve['numfichier']) . ".jpg"));
            $this->affiche($x, $y + $this->hauteurPhoto + $this->hauteurEtiquette, strtoupper($unEleve['nomeleve']), true);
            $this->nbPhotoPage++;

            $x+=$this->largeurPhoto + $this->margeHEntrePhotos;
            if ($this->nbcol <= $i + 1) {
                $i = 0;
                $j++;
                if ($j >= $this->nblig)
                    $numclasse = -2;
                $y+=$this->hauteurPhoto + $this->margeVEntrePhotos;
                $x = $this->margeGauche;
            } else
                $i++;
        }
    }

    private function affiche($x, $y, $texte, $estGras = false, $taille = 10, $estCentreDansLaPage = false) {
        // on décode le texte utf8 -> windows qui est le format utilisé par FPDF (hélas)
        $tex = utf8_decode($texte);
        // s'il est gras...
        if ($estGras) {
            $g = "B";
        } else {
            $g = "";
        }
        $this->SetFont('Arial', $g, $taille);
        if ($estCentreDansLaPage) { // s'il doit être centré dans la page, inutile de redimensionner la police
            $x = $this->margeGauche;
            $l = 0;
        } else {// on redimensionne si cela ne tient pas dans la largeur de l'étiquette
            $l = $this->largeurPhoto;
            $t = $taille - 1;
            while ($this->GetStringWidth($tex) > $this->largeurPhoto and $this->GetStringWidth($tex) > 7) {
                $this->SetFont('Arial', $g, $t--);
            }
        }
        $this->SetX($x);
        $this->SetY($y, false);
        $this->Cell($l, $this->hauteurEtiquette, $tex, 0, 0, 'C');
    }

    function Header() {
        // Logo
        $this->Image($this->logo, 10, 6, 30);

        $this->affiche(0, 10, $this->titre, true, 15, true);
    }

// Pied de page
    function Footer() {
        if ($this->utiliseEchelleVerticale) {
            $s = " | ";
        } else {
            $s = " - ";
        }
        // Positionnement � 1,5 cm du bas
        $this->SetY(-15);
        // Police Arial italique 8
        $this->SetFont('Arial', 'I', 8);
        // date du jour
        $d = date("d/m/Y h:m:s");
        // Num�ro de page
        $this->Cell(0, 10, $this->titre . ' - Page ' . $this->PageNo() . '/{nb} - ' . $d . $s . $this->nbPhotoPage . " photos de " . number_format($this->largeurPhoto, 2, ',', ' ') . " x " . number_format($this->hauteurPhoto, 2, ',', ' '), 0, 0, 'C');
    }

    public function setImage($x, $y, $chemin) {
        if ($this->utiliseEchelleVerticale) {
            $this->Image($chemin, $x, $y, 0, $this->hauteurPhoto);
        } else {
            $this->Image($chemin, $x, $y, $this->largeurPhoto);
        }
    }

}

// initialisations du projet
$PATH = '../';
require_once $PATH . 'inc/class.Session.php';
Session::init();
if (!Session::isLogged()) {
    header("Location: ../index.php"); /* Redirection du navigateur */
} else {
    require_once $PATH . 'inc/class.PDOTrombi.php';
    require_once $PATH . 'inc/class.Parametres.php';
    $pdo = PDOTrombi::getPdoTrombi($PATH);
    $DOSSIERUPLOAD = 'upload/';
// paramètre du trombi 
    $nbcol = 6;
    $nblig = 6;
    $orientation = 'P'; //'P' ou 'L'

    $lesEleves = $pdo->getLesEleves($_SESSION['nt']);
    $pdf = new PDF('Trombinoscope ' . utf8_decode($pdo->getNomTrombi($_SESSION['nt'])), $lesEleves, $PATH . $DOSSIERUPLOAD, $orientation, $nbcol, $nblig,'../images/logo.png');
// gère l'alias pour le nb page
    $pdf->AliasNbPages();
    $pdf->ComposerTrombinoscope();
    $pdf->Output();
    $pdo->setParametres($_SESSION['nt'],$pdf->getParametres());
}

/** converti un entier en hexa sur 8 chiffres
 * 
 * @param type $n
 * @return string de 8 caractères
 */
function dec2hex($n) {
    $num = dechex($n);
    $lim = 8;
    return (strlen($num) >= $lim) ? $num : zeropad("0" . $num, $lim);
}

function zeropad($num, $lim) {
    return (strlen($num) >= $lim) ? $num : zeropad("0" . $num, $lim);
}
