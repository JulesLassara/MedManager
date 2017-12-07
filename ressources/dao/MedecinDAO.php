<?php

require('GenericDAO.php');

class MedecinDAO extends GenericDAO {

    public function __construct(Medecin $element) {
        parent::__construct($element, "medecin", "id_medecin", array('civilite', 'nom', 'prenom'));
    }

}