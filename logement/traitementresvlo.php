





<?php
// Connexion à la base de données
$host = 'localhost';
$db   = 'gofind';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Récupération des données
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $logement_id = $_POST['idl'];
    $identifiant   = $_POST['id'];
    $nb_pieces    = $_POST['nb_pieces'];
    $prix       = $_POST['prix'];

    afficherMessage("erreur",  $prix);
    if (!$logement_id || !$identifiant || !$prix || $nb_pieces <= 0) {
        afficherMessage("Erreur", "Données invalides. Veuillez vérifier le formulaire.");
        exit;
    }

    // Vérifier le logement
    $stmt = $pdo->prepare("SELECT * FROM logement WHERE idl = ?");
    $stmt->execute([$logement_id]);
    $logement = $stmt->fetch();

    if (!$logement) {
        afficherMessage("Erreur", "Logement introuvable.");
        exit;
    }

    if ($logement['nombre_de_pieces_disponibles'] < $nb_pieces) {
        afficherMessage("Erreur", "Pas assez de pièces disponibles.");
        exit;
    }

    // Enregistrer la réservation
    $stmt = $pdo->prepare("INSERT INTO reservation_logement (idl, id, nombre_de_pieces_disponibles, prix) VALUES (?, ?, ?, ?)");
    $stmt->execute([$logement_id, $identifiant, $nb_pieces, $prix]);

    // Mettre à jour les pièces restantes
    $new_pieces = $logement['Nombre_de_pieces_disponibles'] - $nb_pieces;
    $stmt = $pdo->prepare("UPDATE logement SET Nombre_de_pieces_disponibles = ? WHERE id = ?");
    $stmt->execute([$new_pieces, $logement_id]);

    // Message de confirmation
    afficherMessage("Succès", "Votre réservation pour <strong>{$logement['localisation']}</strong> a été enregistrée avec succès !");
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
            background-color: #1b5e20;
        }
    </style>
</head>
<body>
    <div class="confirmation-box">
        <h2>{$titre}</h2>
        <p>{$message}</p>
        <a class="btn" href="logres.php">Retour</a>
    </div>
</body>
</html>
HTML;
}