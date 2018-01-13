<?php
session_start();

/**
 * Vérifie si l'utilisateur est connecté
 * @return 1 s'il est connecté, 0 si non
 */
function isConnected() {
  if(isset($_SESSION['login']) && isset($_SESSION['password'])) {
    if($_SESSION['login'] == "admin" && $_SESSION['password'] == "admin") { // IDENTIFIANT = admin et MDP = admin
      return 1;
    }
  }
  return 0;
}

function loginFailed() {
  if(isset($_SESSION['login']) && isset($_SESSION['password'])) {
    if($_SESSION['login'] != "admin" || $_SESSION['password'] != "admin") { // IDENTIFIANT = admin et MDP = admin
      unset($_SESSION['login']);
      unset($_SESSION['password']);
      return 1;
    }
  }
  return 0;
}
