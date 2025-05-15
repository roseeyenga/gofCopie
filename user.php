<?php
// Connexion à la base de données
$host = 'localhost';
$dbname = 'gofind';
$user = 'root';
$pass = '';
$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);

// Traitement du formulaire
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST["nom"];
    $mot_de_passe = password_hash($_POST["mot_de_passe"], PASSWORD_DEFAULT);
    $email = $_POST["email"];
    $proprietaire = $_POST["proprietaire?"];

    // Vérifie si l'utilisateur existe déjà
    $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE nom = :nom");
    $stmt->execute(['nom' => $nom]);
    $utilisateur = $stmt->fetch();

    if ($utilisateur) {
        // Vérifie si le mot de passe est correct
        if (password_verify($_POST["mot_de_passe"], $utilisateur['mot_de_passe'])) {
            $message = "Bienvenue, " . htmlspecialchars($utilisateur['nom']) . "!<br>Email : " . $utilisateur['email'] . "<br>Propriétaire : " . $utilisateur['proprietaire'];
        } else {
            $message = "Mot de passe incorrect.";
        }
    } else {
        // Insère le nouvel utilisateur
        try{
            $stmt = $conn->prepare("INSERT INTO utilisateurs (nom, mot_de_passe, email, proprietaire) VALUES (:nom, :mot_de_passe, :email, :proprietaire)");
            $stmt->execute([
                'nom' => $nom,
                'mot_de_passe' => $mot_de_passe,
                'email' => $email,
                'proprietaire' => $proprietaire
             ]);
            $message = "Utilisateur ajouté avec succès.";
        }catch(PDOException $e) {
             $message = "Echec de l'ajout :" . $e->getMessage(); 
        }
    }
}
?>
