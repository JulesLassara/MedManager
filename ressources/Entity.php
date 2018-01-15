<?php

require_once('DBTable.php');

abstract class Entity implements DBTable {

    protected $id;
    private $civilite;
    private $nom;
    private $prenom;

    /**
     * Constructeur d'Entity
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

    public function getId() {
        return $this->id;
    }

    public function getCivilite() {
        return $this->civilite;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

}