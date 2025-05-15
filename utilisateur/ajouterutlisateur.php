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
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  $nom = $_POST['nom'];
  $mot_de_passe = $_POST['mot_de_passe'];
  $email = $_POST['email'];

  // Préparation de la requête
  $stmt = $conn->prepare("INSERT INTO utilisateur(nom, mot_de_passe, email)VALUES(?,?,?)");
  if(!$stmt){
    die("Ereeur lors de la préparation: " . $conn->error);
  }
  $stmt->bind_param("sss", $nom, $mot_de_passe, $email);
  
  // Exécution
  if ($stmt->execute()) {
    //echo "Utilisateur ajouté avec succès !";
    header("Location: Menu.php" );
  } else {
    echo "Erreur : " . $stmt->error;
  }$stmt->close();}



$conn->close();
?>
