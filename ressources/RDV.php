<?php
/**
 * Created by PhpStorm.
 * User: jules
 * Date: 30/11/17
 * Time: 10:10
 */

class RDV implements DBTable {

    private $dateheure;
    private $duree;
    private $usager;
    private $medecin;

    /**
     * RDV constructor.
     * @param $dateheure
     * @param $duree
     * @param $usager
     * @param $medecin
     */
    public function __construct($dateheure, $duree, $usager, $medecin)
    {
        $this->dateheure = $dateheure;
        $this->duree = $duree;
        $this->usager = $usager;
        $this->medecin = $medecin;
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
            "dateheure"  => $this->getDateheure(),
            "duree"       => $this->getDuree(),
            "usager"    => $this->getUsager(),
            "medecin"    => $this->getMedecin()
        );
    }
}