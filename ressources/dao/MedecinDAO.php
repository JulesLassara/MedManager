<?php

require('GlobalDAO.php');

class MedecinDAO extends GlobalDAO {

    private $tableName = "medecin";
    private $columns = array('civilite', 'nom', 'prenom');

    public function __construct(Medecin $element) {
        parent::__construct($element);
    }

    public function getColumns() {
        return $this->columns;
    }

    public function getTableName() {
        return $this->tableName;
    }


}