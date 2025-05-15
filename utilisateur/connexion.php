<?php
ini_set('disaplay_errors', 1);
error_reporting(E_ALL);
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
    $mot_de_passe = $_POST['mot_de_passe'];
    

    // Recherche l'utilisateur
    $stmt = $conn->prepare("SELECT * FROM utilisateur  WHERE nom =? ");
    $stmt->execute([$nom]);
    $utilisateur=$stmt->fletch();

        if ($utilisateur && password_verify($mot_de_passe, $utilisateur["mot_de_passe"])){
            //connexion reussie
            $_SESSION["utilisateur_id"]=$utilisateur["id"];
            $_SESSION["utilisateur_nom"]=$utilisateur["nom"];
            header("Location: Menu.php" );
            exit;

        } 
    }


?>