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

    
// Vérifier si un identifiant a été fourni
if (isset($_GET['ida'])) {
    $ida = $_GET['ida'];

    // Requête SQL pour rechercher un appareil par ID
    $sql = 'SELECT * FROM appareil WHERE ida = :ida';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':ida', $ida, PDO::PARAM_INT);

    // Exécution de la requête
    $stmt->execute();

    // Vérification si un appareil a été trouvé
    if ($stmt->rowCount() > 0) {
        $appareil = $stmt->fetch();
            afficherMessage("Alerte!", "Appareil identifié comme volé!");
    exit;

        
    } else {
        afficherMessage("Alerte!", "Aucun appareil trouvé avec cet identifiant.");
        exit;
    }
} else {
    afficherMessage("Alerte!", "Veuillez fournir un identifiant d'appareil.");
    exit;
}

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
            background-color: #000;
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

