<?php
session_start();
include 'header.php';
require_once '../src/gestionAuthentification.php';
require_once '../src/FormHandler.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Démarrage la session si elle n'est pas déjà active
}

// Traitement du formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = FormHandler::sanitizeInput($_POST['email']);
    $password = $_POST['password'];

    // Validation des champs
    $emailError = FormHandler::validateEmail($email);
    $passwordError = FormHandler::validatePassword($password);

    if (!$emailError && !$passwordError) {
        // Si pas d'erreur, essayer de se connecter
        $user = seConnecter($email, $password);

        if ($user) {
            // Connexion réussie, gestion de la session
            connecter_utilisateur($user['id']);
            header('Location: profil.php'); // Redirection vers la page de profil
            exit();
        } else {
            $loginError = "Identifiants incorrects.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="container">
    <h1>Connexion</h1>
    <form method="POST">
        <label for="email">Email :</label>
        <input type="email" name="email" id="email" required value="<?= isset($email) ? htmlspecialchars($email) : ''; ?>">
        <div class="error"><?= isset($emailError) ? htmlspecialchars($emailError) : ''; ?></div>

        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password" required>
        <div class="error"><?= isset($passwordError) ? htmlspecialchars($passwordError) : ''; ?></div>

        <button type="submit">Se connecter</button>
        <div class="error"><?= isset($loginError) ? htmlspecialchars($loginError) : ''; ?></div>
    </form>
    <p>Pas encore inscrit ? <a href="inscription.php">Inscrivez-vous ici</a></p>
    <p><a href="index.php">Retour à l'accueil</a></p>
</div>

<?php require_once 'footer.php'; ?>
</body>
</html>