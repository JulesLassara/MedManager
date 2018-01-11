<?php

require_once('GenericDAO.php');

class RDVDAO extends GenericDAO {

    public function __construct(RDV $element) {
        parent::__construct($element, "rendez_vous", "date_heure_rdv", array('date_heure_rdv', 'id_usager', 'id_medecin', 'duree_rdv'));
    }

    /**
     * Effectue une recherche dans la table de l'élément concerné contenant le mot clé passé en paramètre dans la colonne passée en paramètre
     * @param id_medecin : l'id du médecin concerné par la recherche
     * @return PDOStatement
     */
    public function getElementsByKeywordInColumn($id_medecin) {
        $today = date('Y-m-d H:i', time());
        $res = $this->getConnection()->prepare('SELECT * FROM '.$this->getTableName().' WHERE '.$this->getColumns()[2].' LIKE :id_medecin AND '.$this->getColumns()[0].' > :today');
        $res->execute(array("id_medecin" => $id_medecin,
                            "today"      => $today));
        return $res;
    }

}