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
if ($_SERVER['REQUEST_METHOD'] == 'POST'){$nom = $_POST['nom'];
  $ida = $_POST['ida'];
  $id = $_POST['id'];

  // Préparation de la requête
  $stmt = $conn->prepare("INSERT INTO appareil(ida,nom, id)VALUES(?,?,?)");
  if(!$stmt){
    
    // Message de confirmation
    afficherMessage("Alerte!", "Ereeur lors de la préparation: " . $conn->error );
    exit;

  }
  $stmt->bind_param("sss", $ida, $nom, $id);
  
  // Exécution
  if ($stmt->execute()) {
    //echo "Utilisateur ajouté avec succès !";
    header("Location: RechercheAppareils.html" );
  } else {
    afficherMessage("Alerte!", "Ereeur lors de la préparation: " . $stmt->error );
    exit;
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
          color: #2e7d32;
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
      <a class="btn" href="RechercheAppareils.html">Retour</a>
  </div>
</body>
</html>
HTML;
}
?>