<?php

require('Entity.php');

class Medecin extends Entity {

    /**
     * Medecin constructor.
     */
    public function __construct($civilite, $nom, $prenom) {
        parent::__construct($civilite, $nom, $prenom);
    }

    public function toArray() {
        return array(
            "civilite"  => $this->getCivilite(),
            "nom"       => $this->getNom(),
            "prenom"    => $this->getPrenom()
        );
    }
}
