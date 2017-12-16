<?php
session_start();
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
