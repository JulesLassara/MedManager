<?php

require('DBTable.php');

abstract class Entity implements DBTable {

    private $civilite;
    private $nom;
    private $prenom;

    /**
     * Entity constructor.
     * @param $civilite
     * @param $nom
     * @param $prenom
     */
    public function __construct($civilite, $nom, $prenom) {
        $this->civilite = $civilite;
        $this->nom = $nom;
        $this->prenom = $prenom;
    }

    /**
     * @return la civilite de l'usager
     */
    public function getCivilite()
    {
        return $this->civilite;
    }

    /**
     * @return le nom de l'usager
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @return le prenom de l'usager
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

}