<?php
include 'header.php';
require_once '../src/gestionAuthentification.php';
ob_start(); // Démarre la mise en mémoire tampon de sortie

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
<body>
<div class="container">
    <h1> Profil</h1>
    <!-- Barre de navigation avec bouton de déconnexion -->
    <header class="profile-header">
        <h2>Bienvenue, <?= htmlspecialchars($user_pseudo) ?></h2>
        <div class="logout-button">
            <a href="deconnexion.php">Déconnexion</a>
        </div>
    </header>

            <h2>Informations personnelles</h2>
            <br><strong>Pseudo :</strong>
            <span><?= htmlspecialchars($user_pseudo) ?></span>

        <br><strong>Email :</strong>
            <span><?= htmlspecialchars($user_email) ?></span>



        <br><a href="modifierProfil.php">Modifier mon profil</a><br>
        <a href="changer_mot_de_passe.php">Changer mon mot de passe</a><br>
        <form action="supprimer_compte.php" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ?');">
            <button type="submit">Supprimer mon compte</button>
        </form>

</div>

<!-- Importation de jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?php
    ob_end_flush(); // Envoie le contenu tamponné au navigateur
    include 'footer.php';
    ?>
</body>
</html>

