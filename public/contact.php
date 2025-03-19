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
    $pseudo = FormHandler::sanitizeInput($_POST['pseudo']);
    $email = FormHandler::sanitizeInput($_POST['email']);
    $message = FormHandler::sanitizeInput($_POST['message']);

    // Validation des champs
    $pseudoError = FormHandler::validateLength($pseudo, 2, 50);
    $emailError = FormHandler::validateEmail($email);
    $messageError = FormHandler::validateLength($message, 10, 500);

    if (empty($pseudoError) && empty($emailError) && empty($messageError)) {
        // Ici, vous pouvez ajouter le code pour envoyer le message, par exemple par email
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
            <label for="text">Pseudo :</label>
            <input type="text" name="pseudo" required value="<?= isset($pseudo) ? htmlspecialchars($pseudo) : '' ?>">
            <div class="error"><?= isset($pseudoError) ? htmlspecialchars($pseudoError) : '' ?></div>
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

    </body>
    </html>

<?php
ob_end_flush(); // Envoie le contenu tamponné au navigateur
?>