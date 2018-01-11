<?php

require_once('DBTable.php');

class RDV implements DBTable {

    private $dateheure;
    private $usager;
    private $medecin;
    private $duree;
    private $dateheurefin;

    /**
     * RDV constructor.
     * @param $dateheure
     * @param $usager
     * @param $medecin
     * @param $duree
     */
    public function __construct(DateTime $dateheure, $usager, $medecin, $duree) {
        $this->dateheure = $dateheure;
        $this->usager = $usager;
        $this->medecin = $medecin;
        $this->duree = $duree;
        $this->updateTimeEndRdv();
    }

    /**
     * @return Datetime : la date et l'heure du rendez-vous
     */
    public function getDateheure() {
        return $this->dateheure;
    }

    /**
     * @return : la duree du rendez-vous
     */
    public function getDuree() {
        return $this->duree;
    }

    /**
     * @return l'usager du rendez-vous
     */
    public function getUsager() {
        return $this->usager;
    }

    /**
     * @return le medecin du rendez-vous
     */
    public function getMedecin() {
        return $this->medecin;
    }

    /**
     * @return DateTime : la date et heure de fin du rdv
     */
    public function getDateheureFin() {
        return $this->dateheurefin;
    }

    public function updateTimeEndRdv() {
        $dateheuretmp = $this->dateheure->format("Y-m-d H:i:s");
        $this->dateheurefin = new DateTime($dateheuretmp);
        $this->dateheurefin->modify('+'. $this->duree .' minutes');
    }

    /**
     * Passe au prochain créneau (addition de 30 minutes)
     */
    public function nextSlot() {
        $this->dateheure->modify('+30 minutes');
        $this->dateheurefin->modify('+30 minutes');
    }

    public function nextDay() {
        $this->dateheure->modify('+1 day');
        $this->dateheure->setTime(8, 0, 0);
        $this->updateTimeEndRdv();
    }

    public function toArray() {
        return array(
            "date_heure_rdv" => $this->getDateheure()->format('Y-m-d H:i:s'),
            "id_usager"      => $this->getUsager(),
            "id_medecin"     => $this->getMedecin(),
            "duree_rdv"      => $this->getDuree()
        );
    }
}