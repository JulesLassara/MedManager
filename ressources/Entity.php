<?php

require('DBTable.php');

abstract class Entity implements DBTable {

    private $id;
    private $civilite;
    private $nom;
    private $prenom;

    /**
     * Entity constructor.
     * @param $civilite
     * @param $nom
     * @param $prenom
     */
    public function __construct($id, $civilite, $nom, $prenom) {
        $this->id = $id;
        $this->civilite = $civilite;
        $this->nom = $nom;
        $this->prenom = $prenom;
    }


    /**
     * @return l'id de l'entitee
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return la civilite de l'entitee
     */
    public function getCivilite()
    {
        return $this->civilite;
    }

    /**
     * @return le nom de l'entitee
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @return le prenom de l'entitee
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

}