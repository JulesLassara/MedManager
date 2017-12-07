<?php

require('Entity.php');

class Medecin extends Entity {

    /**
     * Medecin constructor with a nullable id.
     */
    public function __construct($id, $civilite, $nom, $prenom) {
        parent::__construct($id, $civilite, $nom, $prenom);
    }

    public function toArray() {
        if(is_null($this->getId())) {
            return array(
                "civilite"  => $this->getCivilite(),
                "nom"       => $this->getNom(),
                "prenom"    => $this->getPrenom()
            );
        }
        return array(
            "id_medecin"=> $this->getId(),
            "civilite"  => $this->getCivilite(),
            "nom"       => $this->getNom(),
            "prenom"    => $this->getPrenom()
        );
    }
}
