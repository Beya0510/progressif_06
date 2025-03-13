<?php
// Connexion à la base de données
require_once 'src/gestionAuthentification.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = FormHandler::sanitizeInput($_POST['email']);
    $password = $_POST['password'];

    // Validation des champs
    $emailError = FormHandler::validateEmail($email);
    $passwordError = FormHandler::validatePassword($password);

    if (!$emailError && !$passwordError) {
        // Si pas d'erreur, essayer de se connecter
        $user = seConnecter($email, $password);

        if ($user) {
            connecter_utilisateur($user['id']); // Connexion réussie
            header('Location: profil.php'); // Redirection vers le profil
            exit();
        } else {
            $loginError = "Identifiants incorrects.";
        }
    }
}
?>

<!-- Formulaire de Connexion -->
<form method="POST">
    <label for="email">Email :</label>
    <input type="email" name="email" id="email" required>
    <?php if (isset($emailError)) echo "<p>$emailError</p>"; ?>

    <label for="password">Mot de passe :</label>
    <input type="password" name="password" id="password" required>
    <?php if (isset($passwordError)) echo "<p>$passwordError</p>"; ?>

    <button type="submit">Se connecter</button>
    <?php if (isset($loginError)) echo "<p>$loginError</p>"; ?>
</form>

















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
