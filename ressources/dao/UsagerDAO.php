<?php

require_once('GenericDAO.php');

class UsagerDAO extends GenericDAO {

    public function __construct(Usager $element) {
        parent::__construct($element, "usager", "id_usager", array('id_medecin', 'civilite', 'nom', 'prenom', 'adresse', 'date_naissance', 'lieu_naissance', 'num_secu'));
    }

}