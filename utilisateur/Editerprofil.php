<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
    session_start($_SESSION["utilisateur_id"]) {
        header("Location: Connexionxx.html");
        exit;
    }

    if(isset())
    // Paramètres de connexion
    $host = "localhost";
    $user = "root";
    $password = "";
    $dbname = "gofind";


    // Connexion
    $conn = new mysqli($host, $user, $password, $dbname);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    // Vérifie la connexion
    if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
    }

        // Récupération des données du formulaire

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){$nom = $_POST['nom'];
    $mot_de_passe = $_POST['mot_de_passe'];

    
    

    if(empty($mot_de_passe)){
        $hash = password_hash($mot_de_passe, PASSWORD_DEFAULT); 
        $stmt = $conn->prepare("UPDATE utilisateur SET  photo=?, nom=?, mot_de_passe=? WHERE id = ?");
        $stmt->execute([$nom, $hash, $email, $_SESSION["utilisateur_id"]]);
    } else{
        $stmt = $conn->prepare("UPDATE utilisateur SET nom=?, mot_de_passe=? WHERE id = ?");
        $stmt->execute([$photo, $nom, $hash, $email, $_SESSION["utilisateur_id"]]);  
    } 

    $_SESSION["utilisateur_id"]=$nom;
    header("Location: Accueil.html" );
    exit;



    }
        // recupere les infos actuelles
    $stmt = $conn->prepare("SELECT * FROM utilisateur WHERE id=?");   
    $stmt->execute([$_SESSION["utilisateur_id"]]);
    $user=$stmt->fetch();

    header("Location: Accueil.html" );
    exit;    
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GoFind</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: linear-gradient(to bottom, #89a9ce, #89a9ce);
      color: #000;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    .container {
      background-color: rgb(45, 118, 226);
      padding: 30px;
      border-radius: 20px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
      width: 90%;
      max-width: 400px;
      text-align: center;
    }

    .icons {
      display: flex;
      justify-content: space-around;
      margin-bottom: 20px;
    }

    .icons img {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      background-color: #fff;
      padding: 5px;
    }

    h1 {
      margin-bottom: 10px;
    }

    input[type="text"], input[type="password"], input[type="email"], input[type="text"] {
      width: 88%;
      padding: 12px;
      margin: 10px 0;
      border: none;
      border-radius: 8px;
      background-color: #f0f0f0;
    }

    .btn {
      width: 10%;
      padding: 12px;
      margin-top: 10px;
      border: none;
      border-radius: 8px;
      background-color: #000;
      color: #fff;
      font-weight: bold;
      cursor: pointer;
    }

    .separator {
      margin: 20px 0;
      position: relative;
    }

    .separator::before,
    .separator::after {
      content: '';
      position: absolute;
      top: 50%;
      width: 45%;
      height: 1px;
      background: #ccc;
    }

    .separator::before {
      left: 0;
    }

    .separator::after {
      right: 0;
    }

    .separator span {
      background: white;
      padding: 0 10px;
      position: relative;
      z-index: 1;
    }

    .section-title {
      font-weight: bold;
      font-size: 1.2em;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="icons">
      <img src="C:\wamp64\www\gofCopie\Appareils.jpg" alt="Appareils">
      <img src="C:\wamp64\www\gofCopie\Covoiturage.jpg" alt="Covoiturage">
      <img src="C:\wamp64\www\gofCopie\Logement.jpg" alt="Logement">
    </div>
    <h1>GoFind</h1>
    <div>
      <p><strong>Création de compte</strong><br></p>
      <button class="btn1"><img src="C:\wamp64\www\gofCopie\User.png" alt="photo de profil"></button>
    </div>
    <form action="Editerprofil.php" method="POST" enctype="multipart/form-data">
      <label>Photo de profil :</label>
      <input type="text" name="nom" value="<?= htmlspecialchars($user['nom']) ?>" required>
      <input type="password" name="mot_de_passe" value="<?= htmlspecialchars($user['mot de passe']) ?>" required>
      <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
      <a href="Menu.html"><button class="btn">OK</button></a>
    </form>
  </div>
</body>
</html>