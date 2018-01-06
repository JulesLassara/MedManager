<?php

require_once('GenericDAO.php');

class RDVDAO extends GenericDAO {

    public function __construct(RDV $element) {
        parent::__construct($element, "rendez_vous", "date_heure_rdv", array('date_heure_rdv', 'id_usager', 'id_medecin', 'duree_rdv'));
    }

}