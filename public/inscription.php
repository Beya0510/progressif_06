<?php
// Connexion à la base de données
require_once 'src/gestionAuthentification.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = FormHandler::sanitizeInput($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validation des champs
    $emailError = FormHandler::validateEmail($email);
    $passwordError = FormHandler::validatePassword($password);
    $passwordMatchError = FormHandler::validateMatch($password, $confirmPassword);

    if (!$emailError && !$passwordError && !$passwordMatchError) {
        // Si pas d'erreur, essayer de s'inscrire
        $userId = inscrireUtilisateur($email, $password);

        if ($userId) {
            connecter_utilisateur($userId); // Connexion après inscription
            header('Location: profil.php'); // Redirection vers le profil
            exit();
        } else {
            $signupError = "Une erreur est survenue lors de l'inscription.";
        }
    }
}
?>

<!-- Formulaire d'Inscription -->
<form method="POST">
    <label for="email">Email :</label>
    <input type="email" name="email" id="email" required>
    <?php if (isset($emailError)) echo "<p>$emailError</p>"; ?>

    <label for="password">Mot de passe :</label>
    <input type="password" name="password" id="password" required>
    <?php if (isset($passwordError)) echo "<p>$passwordError</p>"; ?>

    <label for="confirm_password">Confirmer le mot de passe :</label>
    <input type="password" name="confirm_password" id="confirm_password" required>
    <?php if (isset($passwordMatchError)) echo "<p>$passwordMatchError</p>"; ?>

    <button type="submit">S'inscrire</button>
    <?php if (isset($signupError)) echo "<p>$signupError</p>"; ?>
</form>
