<?php

require_once(__DIR__.'/../Database.php');

abstract class GenericDAO {

    private $connection;
    private $element;
    private $tableName;
    private $idName;
    private $columns;

    /**
     * Constructeur GenericDAO
     * @param DBTable $element
     * @param $tableName : le nom de la table de l'élément
     * @param $idName : l'id de la table de l'élément
     * @param $columns : les colonnes de la table de l'élément
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

    public function getConnection() {
        return $this->connection;
    }

    public function setElement($element) {
        $this->element = $element;
    }

    /**
     * Vérifie si l'élément existe
     * @return true s'il existe, false si non
     */
    public function exists() { //todo modif pour usager --> check uniquement numéro de sécu
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
     * Vérifie si l'élément existe depuis son ID
     * @return true s'il existe, false si non
     */
    public function existsFromId() {
        $selection = "SELECT * FROM ".$this->getTableName()." WHERE ".$this->getIdName()." LIKE :id";
        $req = $this->connection->prepare($selection);
        $req->execute(array("id" => $this->getElement()->getId()));
        return $req->fetch();
    }


    /**
     * Insertion de l'élément dans la base de données
     * @return true si succès, false si échec
     */
    public function insert() {
        // Requête d'insertion
        $insertion = "INSERT INTO ".$this->getTableName()." (".$this->toStringColumns(false). ") VALUES (".$this->toStringColumns(true).")";
        // Préparation de la requête
        $req = $this->connection->prepare($insertion);
        // Exécution de la requête
        $status = $req->execute($this->element->toArray());

        return $status;
    }


    /**
     * Met à jour l'element courant
     * @return true si succès, false si échec
     */
    public function update() {
        // Préparation de la mise à jour
        $update = "UPDATE ".$this->getTableName()." SET ";
        foreach($this->getColumns() as $info) {
            $update .= $info." = :".$info.",";
        }
        $update = substr($update, 0, -1);
        $update .= " WHERE ".$this->getIdName()." = :".$this->getIdName().";";
        $req = $this->connection->prepare($update);
        // Mise à jour
        $status = $req->execute($this->getElement()->toArray());

        return $status;
    }

    /**
     * Effectue une recherche dans la table de l'élément concerné contenant le mot clé passé en paramètres
     * @param $keyword : le mot clé, si le champs est vide, renvoie toutes les valeurs de la table
     * @return PDOStatement le résultat de la recherche
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
     * Récupère l'élément correspondant à l'id passé en paramètre
     * @param $id l'id correspondant
     * @return array avec les infos de l'élément correspondant
     */
    public function getElementById($id) {
        $res = $this->connection->prepare('SELECT * FROM '.$this->getTableName().' WHERE '.$this->getIdName().' LIKE :id');
        $res->execute(array("id" => $id));
        $res = $res->fetch(PDO::FETCH_ASSOC);
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

    /**
     * Supprime l'élément correspondant à l'ID courant
     */
    public function delete() {
        $delete = "DELETE FROM ".$this->getTableName()." WHERE ".$this->getIdName()." LIKE :id";
        // Preparation de la requete
        $req = $this->connection->prepare($delete);
        // Execution de la requete
        $status = $req->execute(array("id" => $this->getElement()->getId()));

        return $status;
    }

}