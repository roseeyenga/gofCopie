<?php
ini_set('disaplay_errors', 1);
error_reporting(E_ALL);
    session_start();
    // Paramètres de connexion
    $host = "localhost";
    $user = "root";
    $password = "";
    $dbname = "gofind";

// Création de la connexion PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
 
// Requête SQL pour lister les logements
$sql = 'SELECT * FROM logement';
$stmt = $pdo->prepare($sql);
//$stmt->bindParam(':ida', $ida, PDO::PARAM_INT);

// Exécution de la requête
$stmt->execute();


// Récupérer tous les résultats sous forme de tableau associatif
$logements = $stmt->fetchAll(PDO::FETCH_ASSOC);