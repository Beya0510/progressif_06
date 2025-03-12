<?php
// Inclusion du gestionnaire d'authentification
require_once '../src/gestionAuthentification.php';

// Redirection si non connectée
if (!est_connecte()) {
    header('Location: connexion.php');
    exit;
}

try {
    // Récupération des informations de l'utilisateur
    $pdo = new PDO('mysql:host=localhost;dbname=bdd_projet_web', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("SELECT uti_pseudo, uti_email FROM t_utilisateur_uti WHERE uti_id = :id");
    $stmt->execute(['id' => $_SESSION['utilisateurId']]);
    $user = $stmt->fetch();

    if (!$user) {
        throw new Exception("Utilisateur introuvable.");
    }
} catch (PDOException $e) {
    die("Erreur lors de la récupération des données utilisateur : " . $e->getMessage());
}

// Définition du titre de la page et de la méta-description
$pageTitre = "Profil";
$metaDescription = "Page de profil de l'utilisateur.";

// Inclusion de l'en-tête commun
require_once 'header.php';
?>

<h1>Mon Profil</h1>

<p><strong>Pseudo :</strong> <?php echo htmlspecialchars($user['uti_pseudo']); ?></p>
<p><strong>Email :</strong> <?php echo htmlspecialchars($user['uti_email']); ?></p>

<form action="" method="post">
    <button type="submit" name="deconnexion">Déconnexion</button>
</form>

<?php
// Gestion de la déconnexion via le bouton
if (isset($_POST['deconnexion'])) {
    require_once '../src/gestionAuthentification.php';
    deconnecter_utilisateur();
    header('Location: index.php');
    exit;
}

// Inclusion du pied de page commun
require_once 'footer.php';
?>
