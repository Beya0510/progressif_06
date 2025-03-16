<?php
include 'header.php';
require_once '../src/gestionAuthentification.php';
require_once '../src/FormHandler.php';

$pageTitle = "Contact";

// Vérifie si l'utilisateur est connecté
if (!est_connecte()) {
    header('Location: connexion.php'); // Redirection de l'utilisateur vers la page de connexion s'il n'est pas connecté
    exit();
}

// Traitement du formulaire de contact
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = FormHandler::sanitizeInput($_POST['nom']);
    $email = FormHandler::sanitizeInput($_POST['email']);
    $message = FormHandler::sanitizeInput($_POST['message']);

    // Validation des champs
    $nomError = FormHandler::validateLength($nom, 2, 50);
    $emailError = FormHandler::validateEmail($email);
    $messageError = FormHandler::validateLength($message, 10, 500);

    if (empty($nomError) && empty($emailError) && empty($messageError)) {
        $successMessage = "Votre message a été envoyé avec succès.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="container">
    <h1>Contact</h1>
    <form method="POST">
        <label for="nom">Nom :</label>
        <input type="text" name="nom" required value="<?= isset($nom) ? htmlspecialchars($nom) : '' ?>">
        <div class="error"><?= isset($nomError) ? htmlspecialchars($nomError) : '' ?></div>

        <label for="email">Email :</label>
        <input type="email" name="email" required value="<?= isset($email) ? htmlspecialchars($email) : '' ?>">
        <div class="error"><?= isset($emailError) ? htmlspecialchars($emailError) : '' ?></div>

        <label for="message">Message :</label>
        <textarea name="message" required><?= isset($message) ? htmlspecialchars($message) : '' ?></textarea>
        <div class="error"><?= isset($messageError) ? htmlspecialchars($messageError) : '' ?></div>

        <button type="submit">Envoyer</button>
        <div class="success"><?= isset($successMessage) ? htmlspecialchars($successMessage) : '' ?></div>
    </form>
    <p><a href="index.php">Retour à l'accueil</a></p>
</div>

<!-- Importation de jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Importation de votre script menu.js -->
<script src="../assets/Js/menu.js"></script>
</body>
</html>