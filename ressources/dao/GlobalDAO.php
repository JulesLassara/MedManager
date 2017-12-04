<?php

require('/opt/lampp/htdocs/GestionnaireCabinetMedical/ressources/Database.php');

abstract class GlobalDAO {

    private $element;

    /**
     * GlobalDAO constructor.
     * @param $element
     */
    public function __construct(DBTable $element)
    {
        $this->element = $element;
    }

    public abstract function getColumns();
    public abstract function getTableName();



    public function insert() {
        $db = Database::getInstance();
        $columns = $this->getColumns();

        $insertion = "INSERT INTO ".$this->getTableName()." (";

        foreach($columns as $info) {
            $insertion .= $info.", ";
        }
        $insertion[strlen($insertion)-2] = ")";
        $insertion .= "VALUES (";

        foreach($columns as $info) {
            $insertion .= ":".$info.", ";
        }
        $insertion[strlen($insertion)-2] = ")";
        $req = $db->getConnection()->prepare($insertion);
        $status = $req->execute($this->element->toArray());

        return $status;
    }

    function getAll() {
        $db = Database::getInstance();
        $req = $db->getConnection()->prepare('SELECT * FROM '.$this->getTableName());
        $req->execute();
        return $req;
    }

}