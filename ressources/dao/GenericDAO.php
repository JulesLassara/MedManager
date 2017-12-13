<?php

// TODO MODIFIER LE CHEMIN D'ACCES
require('/opt/lampp/htdocs/GestionnaireCabinetMedical/ressources/Database.php');

abstract class GenericDAO {

    private $connection;
    private $element;
    private $tableName;
    private $idName;
    private $columns;

    /**
     * GenericDAO constructor.
     * @param $element
     */
    public function __construct(DBTable $element, $tableName, $idName, $columns) {
        $this->connection = Database::getInstance()->getConnection();
        $this->element = $element;
        $this->tableName = $tableName;
        $this->idName = $idName;
        $this->columns = $columns;
    }

    public function getColumns() {
        return $this->columns;
    }

    public function getTableName() {
        return $this->tableName;
    }

    public function getIdName() {
        return $this->idName;
    }

    public function getElement() {
        return $this->element;
    }

    public function setElement($element) {
        $this->element = $element;
    }

    public function exists() {
        $selection = "SELECT * FROM ".$this->getTableName()." WHERE ";
        foreach($this->getColumns() as $info) {
            $selection .= $info." = :".$info." AND ";
        }
        $selection = substr($selection, 0, -4);
        $req = $this->connection->prepare($selection);
        $req->execute($this->element->toArray());
        return $req->fetch();
    }


    /**
     * Insertion de l'objet dans la base de donnees
     * @return bool = 1 si succes, 0 si echec
     */
    public function insert() {
        // Requete d'insertion
        $insertion = "INSERT INTO ".$this->getTableName()." (".$this->toStringColumns(false). ") VALUES (".$this->toStringColumns(true).")";
        // Preparation de la requete
        $req = $this->connection->prepare($insertion);
        // Execution de la requete
        $status = $req->execute($this->element->toArray());

        return $status;
    }


    /**
     * Met a jour l'element courant
     * @return bool = 1 si succes, 0 si echec
     */
    public function update() {
        //Preparation maj
        $update = "UPDATE ".$this->getTableName()." SET ";
        foreach($this->getColumns() as $info) {
            $update .= $info." = :".$info.",";
        }
        $update = substr($update, 0, -1);
        $update .= " WHERE ".$this->getIdName()." = :".$this->getIdName().";";
        $req = $this->connection->prepare($update);
        //Maj
        $status = $req->execute($this->getElement()->toArray());

        return $status;
    }

    /**
     * Effectue une recherche dans la table de l'element concerne contenant le mot cle passe en parametres
     * @param $keyword le mot cle, si le champs est vide, renvoie toutes les valeurs de la table
     * @return PDOStatement le resultat de la recherche
     */

    //TODO améliorer en mettant les valeurs dans le execute
    public function getElementsByKeyword($keyword) {
        if(empty($keyword)) {
            $res = $this->connection->prepare('SELECT * FROM '.$this->getTableName());
            $res->execute();
        } else {
            $search = "SELECT * FROM ".$this->getTableName()." WHERE ";

            foreach($this->getColumns() as $info) {
                $search .= $info." LIKE '%".$keyword."%' OR ";
            }
            $search = substr($search, 0, -4);

            $res = $this->connection->prepare($search);
            $res->execute();
        }

        return $res;
    }

    /**
     * Recuprere l'element correspondant a l'id passe en parametre
     * @param $id l'id correspondant
     * @return array avec les infos de l'element correspondant
     */
    public function getElementById($id) {
        $res = $this->connection->prepare('SELECT * FROM '.$this->getTableName().' WHERE '.$this->getIdName().' LIKE :id');
        $res->execute(array("id" => $id));
        $res = $res->fetch();
        if($res[$this->getIdName()] == null) {
            return null;
        }
        return $res;
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