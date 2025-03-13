<?php
// Inclusion du fichier de gestion de l'authentification
require_once 'src/gestionAuthentification.php';

// Vérifie si l'utilisateur est connecté
if (!est_connecte()) {
    header('Location: connexion.php'); // Redirige l'utilisateur vers la page de connexion s'il n'est pas connecté
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
        // Ici, vous pouvez ajouter la logique pour envoyer l'email (par exemple avec PHP mail() ou un service comme SMTP)
        $successMessage = "Votre message a été envoyé avec succès.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Contact</title>
</head>
<body>
<form method="POST">
    <label for="nom">Nom :</label>
    <input type="text" name="nom" required value="<?= isset($nom) ? $nom : '' ?>">
    <div><?= isset($nomError) ? $nomError : '' ?></div>

    <label for="email">Email :</label>
    <input type="email" name="email" required value="<?= isset($email) ? $email : '' ?>">
    <div><?= isset($emailError) ? $emailError : '' ?></div>

    <label for="message">Message :</label>
    <textarea name="message" required><?= isset($message) ? $message : '' ?></textarea>
    <div><?= isset($messageError) ? $messageError : '' ?></div>

    <button type="submit">Envoyer</button>

    <div><?= isset($successMessage) ? $successMessage : '' ?></div>
</form>
</body>
</html>
