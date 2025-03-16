<?php
include 'header.php';
require_once '../src/gestionAuthentification.php';


// Vérifier si l'utilisateur est connecté
if (!est_connecte()) {
    header('Location: connexion.php'); // Redirection vers la page de connexion si non connecté
    exit();
}

// Récupérer les informations de l'utilisateur
$conn = new PDO('mysql:host=localhost;dbname=votre_db', 'votre_utilisateur', 'votre_mot_de_passe');
$stmt = $conn->prepare('SELECT * FROM utilisateurS WHERE id = :id');
$stmt->bindParam(':id', $_SESSION['utilisateurId']);
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<h1>Bienvenue, <?php echo htmlspecialchars($user['email']); ?></h1>
<a href="deconnexion.php">Déconnexion</a>
