<?php
session_start();
// Paramètres de connexion
$host = "localhost";
$user = "root";
$password = "";
$dbname = "gofind";

// Connexion
$conn = new mysqli($host, $user, $password, $dbname);

// Vérifie la connexion
if ($conn->connect_error) {
  die("Erreur de connexion : " . $conn->connect_error);
}

// Récupération des données du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST'){$localisation=$_POST['localisation'];
  $dlocation = $_POST['debut_location'];
  $flocation = $_POST['fin_location'];
  $nb_pieces = $_POST['nombre_de_pieces_disponibles'];
  $pieces = $_POST['pieces'];
  $prix = $_POST['prix'];
  $telephone = $_POST['Telephone'];


  // Préparation de la requête
  $stmt = $conn->prepare("INSERT INTO logement(localisation, debut_location, fin_location, nombre_de_pieces_disponibles, description, prix, Telephone)VALUES(?,?,?,?,?,?,?)");
  if(!$stmt){
    die("Ereeur lors de la préparation: " . $conn->error);
  }
  $stmt->bind_param("sssssss", $localisation, $dlocation, $flocation, $nb_pieces,  $pieces, $prix ,$telephone);
  
  // Exécution
  if ($stmt->execute()) {
    // Message de confirmation
    afficherMessage("Succès", "Votre signalement a été enregistré avec succès !");
    header("Location: Logement.html" );
    exit;
  } else {
    echo "Erreur : " . $stmt->error;
  }$stmt->close();}



$conn->close();


// Fonction d'affichage stylisé
function afficherMessage($titre, $message) {
    echo <<<HTML
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>{$titre}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #89a9ce;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .confirmation-box {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            text-align: center;
        }
        .confirmation-box h2 {
            color: #000 ;
        }
        .confirmation-box p {
            margin-top: 10px;
        }
        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #000;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        </tbody>
        .btn:hover {
            background-color: #1b5e20;
        }
    </style>
</head>
<body>
    <div class="confirmation-box">
        <h2>{$titre}</h2>
        <p>{$message}</p>
        <a class="btn" href="Logementxx.php">Retour à la liste des logements</a>
    </div>
</body>
</html>
HTML;
}