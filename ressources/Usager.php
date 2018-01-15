<?php

require_once('Entity.php');

class Usager extends Entity {

    private $medecinref;
    private $adresse;
    private $datenaissance;
    private $lieunaissance;
    private $numsecu;

    /**
     * Constructeur d'Usager (id nullable)
     * @param $id
     * @param $medecinref
     * @param $civilite
     * @param $nom
     * @param $prenom
     * @param $adresse
     * @param $datenaissance
     * @param $lieunaissance
     * @param $numsecu
     */
    public function __construct($id, $medecinref, $civilite, $nom, $prenom, $adresse, $datenaissance, $lieunaissance, $numsecu) {
        parent::__construct($id, $civilite, $nom, $prenom);
        $this->medecinref = $medecinref;
        $this->adresse = $adresse;
        $this->datenaissance = $datenaissance;
        $this->lieunaissance = $lieunaissance;
        $this->numsecu = $numsecu;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getAdresse() {
        return $this->adresse;
    }

    public function getDatenaissance() {
        return $this->datenaissance;
    }

    public function getLieunaissance() {
        return $this->lieunaissance;
    }

    public function getNumsecu() {
        return $this->numsecu;
    }

    public function getMedecinref() {
        return $this->medecinref;
    }

    public function toArray() {
        if(is_null($this->getId())) {
            return array(
                "id_medecin"    => $this->getMedecinref(),
                "civilite"      => $this->getCivilite(),
                "nom"           => $this->getNom(),
                "prenom"        => $this->getPrenom(),
                "adresse"       => $this->getAdresse(),
                "date_naissance" => $this->getDatenaissance(),
                "lieu_naissance" => $this->getLieunaissance(),
                "num_secu"       => $this->getNumsecu()
            );
        }
        return array(
            "id_usager"     => $this->getId(),
            "id_medecin"    => $this->getMedecinref(),
            "civilite"      => $this->getCivilite(),
            "nom"           => $this->getNom(),
            "prenom"        => $this->getPrenom(),
            "adresse"       => $this->getAdresse(),
            "date_naissance" => $this->getDatenaissance(),
            "lieu_naissance" => $this->getLieunaissance(),
            "num_secu"       => $this->getNumsecu()
        );
    }
}