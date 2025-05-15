<?php
session_start();
if (!isset($_SESSION["utilisateur_id"])){
  header("Location: Menu.html");
  exit;
}
echo "Bienvenue, " . htmlspecialchars($_SESSION["utilisateur_id"]) . " !";
?>