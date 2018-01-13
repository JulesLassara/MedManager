<?php

require_once('GenericDAO.php');

class MedecinDAO extends GenericDAO {

    /**
     * Constructeur de MedecinDAO
     * @param Medecin $element
     */
    public function __construct(Medecin $element) {
        parent::__construct($element, "medecin", "id_medecin", array('civilite', 'nom', 'prenom'));
    }

}