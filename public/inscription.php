<?php
session_start();
include 'header.php';
require_once '../src/gestionAuthentification.php';
require_once '../src/FormHandler.php';

// Traitement du formulaire d'inscription
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = FormHandler::sanitizeInput($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validation des champs
    $emailError = FormHandler::validateEmail($email);
    $passwordError = FormHandler::validatePassword($password);
    $passwordMatchError = FormHandler::validateMatch($password, $confirmPassword);

    if (!$emailError && !$passwordError && !$passwordMatchError) {
        $userId = inscrireUtilisateur($email, $password);
        if ($userId) {
            connecter_utilisateur($userId);
            header('Location: profil.php');
            exit();
        } else {
            $signupError = "Une erreur est survenue lors de l'inscription.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="../assets/css/style.css"> <!-- Assurez-vous que le chemin est correct -->
</head>
<body>
<div class="container">
    <h1>Inscription</h1>
    <form method="POST">
        <label for="email">Email :</label>
        <input type="email" name="email" id="email" required value="<?= isset($email) ? htmlspecialchars($email) : ''; ?>">
        <div class="error"><?= isset($emailError) ? htmlspecialchars($emailError) : ''; ?></div>

        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password" required>
        <div class="error"><?= isset($passwordError) ? htmlspecialchars($passwordError) : ''; ?></div>

        <label for="confirm_password">Confirmer le mot de passe :</label>
        <input type="password" name="confirm_password" id="confirm_password" required>
        <div class="error"><?= isset($passwordMatchError) ? htmlspecialchars($passwordMatchError) : ''; ?></div>

        <button type="submit">S'inscrire</button>
        <div class="error"><?= isset($signupError) ? htmlspecialchars($signupError) : ''; ?></div>
    </form>
    <p>Déjà inscrit ? <a href="connexion.php">Connectez-vous ici</a></p>
    <p><a href="index.php">Retour à l'accueil</a></p>
</div>

<?php require_once 'footer.php'; ?> <!-- Inclure le footer -->
</body>
</html>