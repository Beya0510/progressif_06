<?php
// Inclusion du gestionnaire d'authentification
require_once '../src/gestionAuthentification.php';

// Gestion de la déconnexion
if (isset($_GET['action']) && $_GET['action'] === 'deconnexion') {
    deconnecter_utilisateur(); // Déconnecte l'utilisateur
    header('Location: index.php'); // Redirige vers la page d'accueil
    exit; // Termine le script
}

// Redirection si déjà connecté
if (est_connecte()) {
    header('Location: profil.php'); // Redirige vers la page de profil si l'utilisateur est déjà connecté
    exit; // Termine le script
}

// Initialisation des variables
$errors = []; // Tableau pour stocker les erreurs
$pseudo = $motDePasse = ''; // Variables pour stocker les données du formulaire

// Traitement du formulaire lors de la soumission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = trim($_POST['pseudo'] ?? ''); // Récupère et nettoie le pseudo
    $motDePasse = trim($_POST['motDePasse'] ?? ''); // Récupère et nettoie le mot de passe

    try {
        // Connexion à la base de données
        $pdo = new PDO('mysql:host=localhost;dbname=bdd_projet_web', 'root', ''); // Remplacez 'root' et '' par vos identifiants de base de données
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Gestion des erreurs

        // Recherche de l'utilisateur par pseudo
        $stmt = $pdo->prepare("SELECT uti_id, uti_motdepasse FROM t_utilisateur_uti WHERE uti_pseudo = :pseudo");
        $stmt->execute(['pseudo' => $pseudo]); // Exécute la requête avec le pseudo
        $user = $stmt->fetch(); // Récupère l'utilisateur

        // Vérification du mot de passe
        if ($user && password_verify($motDePasse, $user['uti_motdepasse'])) {
            connecter_utilisateur($user['uti_id']); // Connecte l'utilisateur
            header('Location: profil.php'); // Redirige vers la page de profil
            exit; // Termine le script
        } else {
            $errors['general'] = "Identifiants incorrects."; // Message d'erreur si les identifiants sont incorrects
        }
    } catch (PDOException $e) {
        $errors['general'] = "Une erreur est survenue lors de la connexion."; // Gestion des erreurs de connexion à la base de données
    }
}

// Définition du titre de la page et de la méta-description
$pageTitre = "Connexion"; // Titre de la page
$metaDescription = "Page de connexion pour accéder à votre compte."; // Description de la page

// Inclusion de l'en-tête commun
require_once 'header.php';
?>

<h1>Connexion</h1>

<?php if (!empty($errors['general'])) : ?>
    <p class="error-message"><?php echo htmlspecialchars($errors['general']); ?></p> <!-- Affiche le message d'erreur général -->
<?php endif; ?>

<form action="" method="post"> <!-- Formulaire de connexion -->
    <div>
        <label for="pseudo">Pseudo* :</label>
        <input type="text" id="pseudo" name="pseudo" value="<?php echo htmlspecialchars($pseudo); ?>" required> <!-- Champ pour le pseudo -->
    </div>
    <div>
        <label for="motDePasse">Mot de passe* :</label>
        <input type="password" id="motDePasse" name="motDePasse" required> <!-- Champ pour le mot de passe -->
    </div>
    <button type="submit">Se connecter</button> <!-- Bouton pour soumettre le formulaire -->
    <p>Pas encore inscrit ? <a href="inscription.php">Inscrivez-vous ici</a>.</p> <!-- Lien vers la page d'inscription -->
</form>

<?php
// Inclusion du pied de page commun
require_once 'footer.php';
?>



















<?php
//// Inclusion du gestionnaire d'authentification
//require_once '../src/gestionAuthentification.php';
//
//// Gestion de la déconnexion
//if (isset($_GET['action']) && $_GET['action'] === 'deconnexion') {
//    deconnecter_utilisateur();
//    header('Location: index.php');
//    exit;
//}
//
//// Redirection si déjà connecté
//if (est_connecte()) {
//    header('Location: profil.php');
//    exit;
//}
//
//// Initialisation des variables
//$errors = [];
//$pseudo = $motDePasse = '';
//
//// Traitement du formulaire
//if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//    $pseudo = trim($_POST['pseudo'] ?? '');
//    $motDePasse = trim($_POST['motDePasse'] ?? '');
//
//    try {
//        // Connexion à la base de données
//        $pdo = new PDO('mysql:host=localhost;dbname=bdd_projet_web', 'root', '');
//        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//
//        // Recherche de l'utilisateur par pseudo
//        $stmt = $pdo->prepare("SELECT uti_id, uti_motdepasse FROM t_utilisateur_uti WHERE uti_pseudo = :pseudo");
//        $stmt->execute(['pseudo' => $pseudo]);
//        $user = $stmt->fetch();
//
//        // Vérification du mot de passe
//        if ($user && password_verify($motDePasse, $user['uti_motdepasse'])) {
//            connecter_utilisateur($user['uti_id']);
//            header('Location: profil.php');
//            exit;
//        } else {
//            $errors['general'] = "Identifiants incorrects.";
//        }
//    } catch (PDOException $e) {
//        $errors['general'] = "Une erreur est survenue lors de la connexion.";
//    }
//}
//
//// Définition du titre de la page et de la méta-description
//$pageTitre = "Connexion";
//$metaDescription = "Page de connexion pour accéder à votre compte.";
//
//// Inclusion de l'en-tête commun
//require_once 'header.php';
//?>
<!---->
<!--<h1>Connexion</h1>-->
<!---->
<?php //if (!empty($errors['general'])) : ?>
<!--    <p class="error-message">--><?php //echo htmlspecialchars($errors['general']); ?><!--</p>-->
<?php //endif; ?>
<!---->
<!--<form action="" method="post">-->
<!--    <div>-->
<!--        <label for="pseudo">Pseudo* :</label>-->
<!--        <input type="text" id="pseudo" name="pseudo" value="--><?php //echo htmlspecialchars($pseudo); ?><!--" required>-->
<!--    </div>-->
<!--    <div>-->
<!--        <label for="motDePasse">Mot de passe* :</label>-->
<!--        <input type="password" id="motDePasse" name="motDePasse" required>-->
<!--    </div>-->
<!--    <button type="submit">Se connecter</button>-->
<!--    <p>Pas encore inscrit ? <a href="inscription.php">Inscrivez-vous ici</a>.</p>-->
<!--</form>-->
<!---->
<?php
//// Inclusion du pied de page commun
//require_once 'footer.php';
//?>
