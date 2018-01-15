<?php

require_once('GenericDAO.php');

class UsagerDAO extends GenericDAO {

    /**
     * Constructeur de UsagerDAO
     * @param Usager $element
     */
    public function __construct(Usager $element) {
        parent::__construct($element, "usager", "id_usager", array('id_medecin', 'civilite', 'nom', 'prenom', 'adresse', 'date_naissance', 'lieu_naissance', 'num_secu'));
    }

    /**
     * Vérifie si l'élément existe
     * @return true s'il existe, false si non
     */
    public function exists() {
        $selection = "SELECT * FROM ".$this->getTableName()." WHERE ".$this->getColumns()[7]." LIKE :num_secu;";
        $req = $this->getConnection()->prepare($selection);
        $req->execute(array("num_secu" => $this->getElement()->getNumsecu()));
        return $req->fetch(PDO::FETCH_ASSOC);
    }

}