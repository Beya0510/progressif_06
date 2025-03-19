<?php
include 'header.php';

require_once '../src/gestionAuthentification.php';
ob_start(); // Démarre la mise en mémoire tampon de sortie
if(session_status() === PHP_SESSION_NONE) {
    session_start(); }

// Vérifier si l'utilisateur est connecté
if (!est_connecte()) {
    header('Location: connexion.php');
    exit();
}

$conn = getConnexion();

// Récupérer les informations actuelles de l'utilisateur
$stmt = $conn->prepare('SELECT * FROM t_utilisateur_uti WHERE uti_id = :id');
$stmt->bindParam(':id', $_SESSION['uti_id']);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Traitement du formulaire de modification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = trim($_POST['pseudo']);
    $email = trim($_POST['email']);
    $nom_complet = trim($_POST['nom_complet'] ?? '');
    $avatar = $user['uti_avatar']; // Conserver l'ancien avatar par défaut

    // Validation des champs
    if (empty($pseudo) || empty($email)) {
        $errorMessage = "Veuillez remplir tous les champs obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "L'adresse email est invalide.";
    } else {
        // Vérifier si le pseudo ou l'email existe déjà pour un autre utilisateur
        $stmt = $conn->prepare('SELECT * FROM t_utilisateur_uti WHERE (uti_pseudo = :pseudo OR uti_email = :email) AND uti_id != :id');
        $stmt->bindParam(':pseudo', $pseudo);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $_SESSION['uti_id']);
        $stmt->execute();

        if ($stmt->fetch(PDO::FETCH_ASSOC)) {
            $errorMessage = "Le pseudo ou l'email est déjà utilisé par un autre utilisateur.";
        } else {
            // Mettre à jour les informations de l'utilisateur
            $stmt = $conn->prepare('UPDATE t_utilisateur_uti SET uti_pseudo = :pseudo, uti_email = :email WHERE uti_id = :id');
            $stmt->bindParam(':pseudo', $pseudo);
            $stmt->bindParam(':email', $email);
            //$stmt->bindParam(':nom_complet', $nom_complet);
            $stmt->bindParam(':id', $_SESSION['uti_id']);

            if ($stmt->execute()) {
                $successMessage = "Votre profil a été mis à jour avec succès.";
            } else {
                $errorMessage = "Une erreur est survenue lors de la mise à jour.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier mon profil</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="container">
    <h1>Modifier mon profil</h1>

    <?php if (isset($successMessage)): ?>
        <div class="success"><?= htmlspecialchars($successMessage) ?></div>
    <?php endif; ?>

    <?php if (isset($errorMessage)): ?>
        <div class="error"><?= htmlspecialchars($errorMessage) ?></div>
    <?php endif; ?>

    <form method="POST">
        <!-- Pseudo -->
        <label for="pseudo">Pseudo :</label>
        <input type="text" id="pseudo" name="pseudo" value="<?= htmlspecialchars($user['uti_pseudo']) ?>" required>

        <!-- Email -->
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['uti_email']) ?>" required>

        <!-- Nom complet (facultatif) -->
        <label for="nom_complet">Nom complet :</label>
        <input type="text" id="nom_complet" name="nom_complet" value="<?= htmlspecialchars($user['uti_nom_complet'] ?? '') ?>">

        <button type="submit">Enregistrer les modifications</button>
    </form>
</div>
</body>
</html>

<?php
ob_end_flush(); // Envoie le contenu tamponné au navigateur
include 'footer.php';
?>