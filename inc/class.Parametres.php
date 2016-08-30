<?php

class Parametres {

    private $titre, $nbcol, $nblig, $orientation, $logo, $margeDroite,
            $margeGauche, $margeBas, $hauteurTitre, $hauteurEtiquette,
            $margeHEntrePhotos, $margeVEntrePhotos, $largeurMin,
            $largeurMax, $largeurMoy, $hauteurMin, $hauteurMax,
            $hauteurMoy, $path;

    function setTitre($titre) {
        $this->titre = $titre;
    }

    function setNbcol($nbcol) {
        $this->nbcol = $nbcol;
    }

    function setNblig($nblig) {
        $this->nblig = $nblig;
    }

    function setOrientation($orientation) {
        $this->orientation = $orientation;
    }

    function setLogo($logo) {
        $this->logo = $logo;
    }

    function getTitre() {
        return $this->titre;
    }

    function getNbcol() {
        return $this->nbcol;
    }

    function getNblig() {
        return $this->nblig;
    }

    function getOrientation() {
        return $this->orientation;
    }

    function getLogo() {
        return $this->logo;
    }

    function getMargeDroite() {
        return $this->margeDroite;
    }

    function getMargeGauche() {
        return $this->margeGauche;
    }

    function getMargeBas() {
        return $this->margeBas;
    }

    function getHauteurTitre() {
        return $this->hauteurTitre;
    }

    function getHauteurEtiquette() {
        return $this->hauteurEtiquette;
    }

    function getMargeHEntrePhotos() {
        return $this->margeHEntrePhotos;
    }

    function getMargeVEntrePhotos() {
        return $this->margeVEntrePhotos;
    }

    function getLargeurMin() {
        return $this->largeurMin;
    }

    function getLargeurMax() {
        return $this->largeurMax;
    }

    function getLargeurMoy() {
        return $this->largeurMoy;
    }

    function getHauteurMin() {
        return $this->hauteurMin;
    }

    function getHauteurMax() {
        return $this->hauteurMax;
    }

    function getHauteurMoy() {
        return $this->hauteurMoy;
    }

    function setMargeDroite($margeDroite) {
        $this->margeDroite = $margeDroite;
    }

    function setMargeGauche($margeGauche) {
        $this->margeGauche = $margeGauche;
    }

    function setMargeBas($margeBas) {
        $this->margeBas = $margeBas;
    }

    function setHauteurTitre($hauteurTitre) {
        $this->hauteurTitre = $hauteurTitre;
    }

    function setHauteurEtiquette($hauteurEtiquette) {
        $this->hauteurEtiquette = $hauteurEtiquette;
    }

    function setMargeHEntrePhotos($margeHEntrePhotos) {
        $this->margeHEntrePhotos = $margeHEntrePhotos;
    }

    function setMargeVEntrePhotos($margeVEntrePhotos) {
        $this->margeVEntrePhotos = $margeVEntrePhotos;
    }

    function setLargeurMin($largeurMin) {
        $this->largeurMin = $largeurMin;
    }

    function setLargeurMax($largeurMax) {
        $this->largeurMax = $largeurMax;
    }

    function setLargeurMoy($largeurMoy) {
        $this->largeurMoy = $largeurMoy;
    }

    function setHauteurMin($hauteurMin) {
        $this->hauteurMin = $hauteurMin;
    }

    function setHauteurMax($hauteurMax) {
        $this->hauteurMax = $hauteurMax;
    }

    function setHauteurMoy($hauteurMoy) {
        $this->hauteurMoy = $hauteurMoy;
    }

    function getPath() {
        return $this->path;
    }

    function setPath($path) {
        $this->path = $path;
    }

    function __construct($titre, $nbcol, $nblig, $orientation, $path, $logo, $margeDroite, $margeGauche, $margeBas, $hauteurTitre, $hauteurEtiquette, $margeHEntrePhotos, $margeVEntrePhotos, $largeurMin, $largeurMax, $largeurMoy, $hauteurMin, $hauteurMax, $hauteurMoy) {
        $this->titre = $titre;
        $this->nbcol = $nbcol;
        $this->nblig = $nblig;
        $this->orientation = $orientation;
        $this->logo = $logo;
        $this->margeDroite = $margeDroite;
        $this->margeGauche = $margeGauche;
        $this->margeBas = $margeBas;
        $this->hauteurTitre = $hauteurTitre;
        $this->hauteurEtiquette = $hauteurEtiquette;
        $this->margeHEntrePhotos = $margeHEntrePhotos;
        $this->margeVEntrePhotos = $margeVEntrePhotos;
        $this->largeurMin = $largeurMin;
        $this->largeurMax = $largeurMax;
        $this->largeurMoy = $largeurMoy;
        $this->hauteurMin = $hauteurMin;
        $this->hauteurMax = $hauteurMax;
        $this->hauteurMoy = $hauteurMoy;
        $this->path = $path;
    }

}
