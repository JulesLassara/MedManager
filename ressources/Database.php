<?php

class Database {

    private $linkpdo;
    private static $_instance;

    /**
     * Récupère l'instance de la connexion ou la crée si elle n'existe pas
     * @return Database
     */
    public static function getInstance() {
        if(is_null(self::$_instance)) {
            self::$_instance = new Database();
        }
        return self::$_instance;
    }

    private function __construct() {
        try {
            $this->linkpdo = new PDO("mysql:host=localhost;dbname=gest_cabinet_medical", "root", "\$iutinfophp");
            $this->linkpdo->exec("SET CHARACTER SET UTF8");
        } catch (Exception $e) {
            die('Erreur : '.$e->getMessage());
        }
    }

    /**
     * Récupère la connexion à la DB
     * @return PDO
     */
    public function getConnection() {
        return $this->linkpdo;
    }
}