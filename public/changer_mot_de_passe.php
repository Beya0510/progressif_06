<?php

require_once '../src/gestionAuthentification.php';

if(session_status() === PHP_SESSION_NONE) {
    session_start(); }


// Vérifier si l'utilisateur est connecté
if (!est_connecte()) {
    header('Location: connexion.php');
    exit();
}

$conn = getConnexion();

$errorMessage = '';
$successMessage = '';

// Traitement du formulaire de changement de mot de passe
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ancien_mot_de_passe = $_POST['ancien_mot_de_passe'];
    $nouveau_mot_de_passe = $_POST['nouveau_mot_de_passe'];
    $confirmer_mot_de_passe = $_POST['confirmer_mot_de_passe'];

    // Vérifier que l'ancien mot de passe est correct
    $stmt = $conn->prepare('SELECT uti_motdepasse FROM t_utilisateur_uti WHERE uti_id = :id');
    $stmt->bindParam(':id', $_SESSION['uti_id']);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!password_verify($ancien_mot_de_passe, $user['uti_motdepasse'])) {
        $errorMessage = "L'ancien mot de passe est incorrect.";
    } elseif ($nouveau_mot_de_passe !== $confirmer_mot_de_passe) {
        $errorMessage = "Les nouveaux mots de passe ne correspondent pas.";
    } elseif (strlen($nouveau_mot_de_passe) < 8) {
        $errorMessage = "Le nouveau mot de passe doit contenir au moins 8 caractères.";
    } else {
        // Hacher le nouveau mot de passe et le mettre à jour
        $hashedPassword = password_hash($nouveau_mot_de_passe, PASSWORD_BCRYPT);
        $stmt = $conn->prepare('UPDATE t_utilisateur_uti SET uti_motdepasse = :mot_de_passe WHERE uti_id = :id');
        $stmt->bindParam(':mot_de_passe', $hashedPassword);
        $stmt->bindParam(':id', $_SESSION['uti_id']);

        if ($stmt->execute()) {
            $successMessage = "Votre mot de passe a été changé avec succès.";
        } else {
            $errorMessage = "Une erreur est survenue lors du changement de mot de passe.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Changer mon mot de passe</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="container">
    <h1>Changer mon mot de passe</h1>

    <?php if (isset($successMessage)): ?>
        <div class="success"><?= htmlspecialchars($successMessage) ?></div>
    <?php endif; ?>

    <?php if (isset($errorMessage)): ?>
        <div class="error"><?= htmlspecialchars($errorMessage) ?></div>
    <?php endif; ?>

    <form method="POST">
        <!-- Ancien mot de passe -->
        <label for="ancien_mot_de_passe">Ancien mot de passe :</label>
        <input type="password" id="ancien_mot_de_passe" name="ancien_mot_de_passe" required>

        <!-- Nouveau mot de passe -->
        <label for="nouveau_mot_de_passe">Nouveau mot de passe :</label>
        <input type="password" id="nouveau_mot_de_passe" name="nouveau_mot_de_passe" required>

        <!-- Confirmation du nouveau mot de passe -->
        <label for="confirmer_mot_de_passe">Confirmer le nouveau mot de passe :</label>
        <input type="password" id="confirmer_mot_de_passe" name="confirmer_mot_de_passe" required>

        <button type="submit">Changer le mot de passe</button>
    </form>
</div>
</body>
</html>
