<?php

require_once('GenericDAO.php');

class RDVDAO extends GenericDAO {

    /**
     * Constructeur de RDVDAO
     * @param RDV $element
     */
    public function __construct(RDV $element) {
        parent::__construct($element, "rendez_vous", "date_heure_rdv", array('date_heure_rdv', 'id_usager', 'id_medecin', 'duree_rdv'));
    }

    /**
     * Effectue une recherche dans la table de l'élément concerné contenant l'id du médecin passé en paramètres
     * @param id_medecin : l'id du médecin concerné par la recherche
     * @param oldrdv : true pour avoir tous les rendez-vous, false pour avoir uniquement les rendez-vous à compter du jour courant
     * @return PDOStatement
     */
    public function getElementsByIdMedecin($id_medecin, $oldrdv) {
        $today = date('Y-m-d H:i', time());
        if($oldrdv){
            $res = $this->getConnection()->prepare('SELECT * FROM '.$this->getTableName().' WHERE '.$this->getColumns()[2].' LIKE :id_medecin');
            $res->execute(array("id_medecin" => $id_medecin));
        } else {
            $res = $this->getConnection()->prepare('SELECT * FROM '.$this->getTableName().' WHERE '.$this->getColumns()[2].' LIKE :id_medecin AND '.$this->getColumns()[0].' > :today');
            $res->execute(array("id_medecin" => $id_medecin,
                                "today"      => $today));
        }
        return $res;
    }

    public function getElementByIds($date, $idmed) {
        $res = $this->getConnection()->prepare('SELECT * FROM '.$this->getTableName().' WHERE '.$this->getColumns()[0].' LIKE :date AND '.$this->getColumns()[2].' LIKE :idmed');
        $res->execute(array("date" => $date,
                            "idmed"=> $idmed));
        $res = $res->fetch(PDO::FETCH_ASSOC);
        if($res[$this->getIdName()] == null) {
            return null;
        }
        return $res;
    }

    /**
     * Met à jour l'element courant
     * @param $daterdv : Ancienne date du rendez-vous
     * @param $idmedecin : Ancin id du médecin
     * @return true si succès, false si échec
     */
    public function update($daterdv, $idmedecin) {
        // Préparation de la mise à jour
        $update = "UPDATE ".$this->getTableName()." SET ";
        foreach($this->getColumns() as $info) {
            $update .= $info." = :".$info.",";
        }
        if($this instanceof RDVDAO) {
            $update = substr($update, 0, -1);
            $update .= " WHERE ".$this->getColumns()[0]." = '".$daterdv."' AND ".$this->getColumns()[2]." = ".$idmedecin.";";
        } else {
            $update = substr($update, 0, -1);
            $update .= " WHERE ".$this->getIdName()." = :".$this->getIdName().";";
        }

        $req = $this->getConnection()->prepare($update);
        // Mise à jour
        $status = $req->execute($this->getElement()->toArray());

        return $status;
    }

    public function delete() {
        $delete = "DELETE FROM ".$this->getTableName()." WHERE ".$this->getColumns()[0]." LIKE :date AND ".$this->getColumns()[2]." LIKE :idmed";
        // Preparation de la requete
        $req = $this->getConnection()->prepare($delete);
        // Execution de la requete
        $status = $req->execute(array("date" => $this->getElement()->getDateheure()->format("Y-m-d H:i:s"),
                                      "idmed"=> $this->getElement()->getMedecin()));

        return $status;
    }

    function existsFromIds($date, $idmed) {
        return $this->getElementByIds($date, $idmed) != 0;
    }

    public function getNbHeures($id_medecin) {
        $res = $this->getConnection()->prepare('SELECT SUM(duree_rdv) AS heures FROM '.$this->getTableName().' WHERE '.$this->getColumns()[2]." LIKE :idmed");
        $res->execute(array("idmed" => $id_medecin));
        $minutes = $res->fetch()['heures'];
        return date('H:i:s', mktime(0,$minutes, 0));
    }

    public function deleteByUsagerId($id) {
        $req = $this->getConnection()->prepare('DELETE FROM '.$this->getTableName().' WHERE '.$this->getColumns()[1].' = :id;');
        $status = $req->execute(array("id" => $id));
        return $status;
    }

}