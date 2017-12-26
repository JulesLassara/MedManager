<?php

require_once('Entity.php');

class Usager extends Entity {

    private $adresse;
    private $datenaissance;
    private $lieunaissance;
    private $numsecu;
    private $medecinref;

    /**
     * Usager constructor with a nullable id.
     * @param $id
     * @param $civilite
     * @param $nom
     * @param $prenom
     * @param $adresse
     * @param $datenaissance
     * @param $lieunaissance
     * @param $numsecu
     * @param $medecinref
     */
    public function __construct($id, $civilite, $nom, $prenom, $adresse, $datenaissance, $lieunaissance, $numsecu, $medecinref) {
        parent::__construct($id, $civilite, $nom, $prenom);
        $this->adresse = $adresse;
        $this->datenaissance = $datenaissance;
        $this->lieunaissance = $lieunaissance;
        $this->numsecu = $numsecu;
        $this->medecinref = $medecinref;
    }

    /**
     * @return l'adresse de l'usager
     */
    public function getAdresse() {
        return $this->adresse;
    }

    /**
     * @return la date de naissance de l'usager
     */
    public function getDatenaissance() {
        return $this->datenaissance;
    }

    /**
     * @return le lieu de naissance de l'usager
     */
    public function getLieunaissance() {
        return $this->lieunaissance;
    }

    /**
     * @return le numero de securite sociale de l'usager
     */
    public function getNumsecu() {
        return $this->numsecu;
    }

    /**
     * @return le medecin referent de l'usager
     */
    public function getMedecinref() {
        return $this->medecinref;
    }

    public function toArray()
    {
        return array(
            "civilite"      => $this->getCivilite(),
            "nom"           => $this->getNom(),
            "prenom"        => $this->getPrenom(),
            "adresse"       => $this->getAdresse(),
            "datenaissance" => $this->getDatenaissance(),
            "lieunaissance" => $this->getLieunaissance(),
            "numsecu"       => $this->getNumsecu()
        );
    }
}