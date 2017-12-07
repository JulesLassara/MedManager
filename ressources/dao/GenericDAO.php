<?php

require('/opt/lampp/htdocs/GestionnaireCabinetMedical/ressources/Database.php');

abstract class GenericDAO {

    private $connection;
    private $element;
    private $tableName;
    private $columns;

    /**
     * GenericDAO constructor.
     * @param $element
     */
    public function __construct(DBTable $element, $tableName, $columns) {
        $this->connection = Database::getInstance()->getConnection();
        $this->element = $element;
        $this->tableName = $tableName;
        $this->columns = $columns;
    }

    public function getColumns() {
        return $this->columns;
    }

    public function getTableName() {
        return $this->tableName;
    }


    public function exists() {
        $selection = "SELECT * FROM ".$this->getTableName()." WHERE ";
        foreach($this->getColumns() as $info) {
            $selection .= $info." = :".$info." AND ";
        }
        $selection = substr($selection, 0, -4);
        $req = $this->connection->prepare($selection);
        $req->execute($this->element->toArray());
        return count($req->fetch());
    }


    /**
     * Insertion de l'objet dans la base de donnees
     * @return bool = 1 si succes, 0 si echec
     */
    public function insert() {
        $insertion = "INSERT INTO ".$this->getTableName()." (".$this->toStringColumns(false). ") VALUES (".$this->toStringColumns(true).")";
        $req = $this->connection->prepare($insertion);
        $status = $req->execute($this->element->toArray());

        return $status;
    }

    /**
     * Recupere toutes les informations de l'entite
     * @return PDOStatement
     */
    public function getAll() {
        $req = $this->connection->prepare("SELECT * FROM ".$this->getTableName());
        $req->execute();
        return $req;
    }

    /**
     * Retourne un string contenant les colonnes de la table courrante au bon format
     * @param $dots = true pour avoir ":" devant chaque valeurs, false pour ne pas les avoir
     * @return string
     */
    private function toStringColumns($dots) {
        $columns = $this->getColumns();
        $result = "";
        if($dots) {
            foreach($columns as $info) {
                $result .= ":".$info.", ";
            }
        } else {
            foreach($columns as $info) {
                $result .= $info.", ";
            }
        }
        $result = substr($result, 0,-2);
        return $result;
    }

}