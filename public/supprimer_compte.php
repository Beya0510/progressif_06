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

// Supprimer le compte
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Supprimer l'utilisateur de la base de données
        $stmt = $conn->prepare('DELETE FROM t_utilisateur_uti WHERE uti_id = :id');
        $stmt->bindParam(':id', $_SESSION['uti_id']);

        if ($stmt->execute()) {
            // Déconnecter l'utilisateur
            deconnecter_utilisateur();
            header('Location: index.php'); // Redirection vers la page d'accueil
            exit();
        } else {
            $errorMessage = "Une erreur est survenue lors de la suppression du compte.";
        }
    } catch (PDOException $e) {
        $errorMessage = "Erreur de base de données : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer mon compte</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="container">
    <h1>Supprimer mon compte</h1>

    <?php if (isset($errorMessage)): ?>
        <div class="error"><?= htmlspecialchars($errorMessage) ?></div>
    <?php endif; ?>

    <p>Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.</p>

    <form method="POST" onsubmit="return confirm('Êtes-vous vraiment sûr de vouloir supprimer votre compte ?');">
        <button type="submit">Supprimer mon compte</button>
    </form>
</div>
</body>
</html>
