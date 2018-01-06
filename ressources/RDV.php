<?php

class RDV implements DBTable {

    private $dateheure;
    private $usager;
    private $medecin;
    private $duree;

    /**
     * RDV constructor.
     * @param $dateheure
     * @param $usager
     * @param $medecin
     * @param $duree
     */
    public function __construct($dateheure, $usager, $medecin, $duree)
    {
        $this->dateheure = $dateheure;
        $this->usager = $usager;
        $this->medecin = $medecin;
        $this->duree = $duree;
    }

    /**
     * @return la date et l'heure du rendez-vous
     */
    public function getDateheure()
    {
        return $this->dateheure;
    }

    /**
     * @return la duree du rendez-vous
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * @return l'usager du rendez-vous
     */
    public function getUsager()
    {
        return $this->usager;
    }

    /**
     * @return le medecin du rendez-vous
     */
    public function getMedecin()
    {
        return $this->medecin;
    }


    public function toArray() {
        return array(
            "date_heure_rdv" => $this->getDateheure(),
            "id_usager"    => $this->getUsager(),
            "id_medecin"   => $this->getMedecin(),
            "duree_rdv"     => $this->getDuree()
        );
    }
}