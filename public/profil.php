<?php
require_once '../src/gestionAuthentification.php';
//ob_start(); // Démarre la mise en mémoire tampon de sortie
//
//if(session_status() === PHP_SESSION_NONE) {
//    session_start(); // Démarrage de la session si elle n'est pas déjà active
//}
//
//include 'header.php';
//require_once '../src/gestionAuthentification.php';
//
//// Vérifier si l'utilisateur est connecté
//if (!est_connecte()) {
//    header('Location: connexion.php'); // Redirection vers la page de connexion si non connecté
//    exit();
//}
//
//// Récupérer les informations de l'utilisateur
//try {
//    $conn = new PDO('mysql:host=localhost;dbname=bdd_projet_web;charset=utf8', 'root', ''); // Remplacez 'root' et '' par vos identifiants
//    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Gestion des erreurs
//    $stmt = $conn->prepare('SELECT * FROM t_utilisateur_uti WHERE uti_id = :id');
//    $stmt->bindParam(':id', $_SESSION['utilisateurId']);
//    $stmt->execute();
//
//    $user = $stmt->fetch(PDO::FETCH_ASSOC);
//
//    if (!$user) {
//        throw new Exception("Utilisateur non trouvé.");
//    }
//} catch (PDOException $e) {
//    die("Erreur de connexion à la base de données : " . $e->getMessage());
//} catch (Exception $e) {
//    die($e->getMessage());
//}
//?-->


// Vérifie si l'utilisateur est connecté
if (!est_connecte()) {
    header('Location: connexion.php'); // Redirection de l'utilisateur vers la page de connexion s'il n'est pas connecté
    exit();
}

$conn = getConnexion(); // Fonction pour obtenir la connexion PDO

// Récupérer les infos de l'utilisateur depuis la base de données
$stmt = $conn->prepare("SELECT uti_pseudo, uti_email FROM t_utilisateur_uti WHERE uti_id = :uti_id");
$stmt->bindParam(':uti_id', $_SESSION['uti_id']);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$user_pseudo = $user['uti_pseudo'];
$user_email = $user['uti_email'];

// Vérifier si l'utilisateur existe
if (!$user) {
    session_destroy(); // Détruire la session si l'utilisateur n'existe plus
    header("Location: profil.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body> <h1> Profil</h1>
<div class="container">
    <!-- Barre de navigation avec bouton de déconnexion -->
    <header class="profile-header">
        <h1>Bienvenue, <?= htmlspecialchars($user_pseudo) ?></h1>
        <div class="logout-button">
            <a href="deconnexion.php">Déconnexion</a>
        </div>
    </header>

    <!-- Section des informations du profil -->
    <div class="profile-info">
        <h2>Informations personnelles</h2>

        <!-- Pseudo -->
        <div class="profile-detail">
            <strong>Pseudo :</strong>
            <span><?= htmlspecialchars($user_pseudo) ?></span>
        </div>

        <!-- Email -->
        <div class="profile-detail">
            <strong>Email :</strong>
            <span><?= htmlspecialchars($user_email) ?></span>
        </div>

    <!-- Actions disponibles -->
    <div class="profile-actions">
        <a href="modifierProfil.php">Modifier mon profil</a><br>
        <a href="changer_mot_de_passe.php">Changer mon mot de passe</a><br>
        <form action="supprimer_compte.php" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ?');">
            <button type="submit">Supprimer mon compte</button>
        </form>
    </div>
</div>

<!-- Importation de jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>