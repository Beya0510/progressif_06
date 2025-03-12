<?php
require_once '../src/FormHandler.php';

// Initialisation des variables
$pseudo = $email = $motDePasse = $confirmationMotDePasse = '';
$errors = [];
$formSubmitted = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// Validation du pseudo
$pseudo = isset($_POST['inscription_pseudo']) ? $_POST['inscription_pseudo'] : '';
$errors['pseudo'] = FormHandler::validateLength($pseudo, 2, 255);
$pseudo = FormHandler::sanitizeInput($pseudo);

// Validation de l'email
$email = isset($_POST['inscription_email']) ? $_POST['inscription_email'] : '';
$errors['email'] = FormHandler::validateEmail($email, true);
$email = FormHandler::sanitizeInput($email);

// Validation du mot de passe
$motDePasse = $_POST['inscription_motDePasse'] ?? '';
$errors['motDePasse'] = FormHandler::validatePassword($motDePasse);

// Validation de la confirmation du mot de passe
$confirmationMotDePasse = $_POST['inscription_motDePasse_confirmation'] ?? '';
if ($motDePasse && $confirmationMotDePasse) {
$errors['confirmationMotDePasse'] = FormHandler::validateMatch($motDePasse, $confirmationMotDePasse);
} else {
$errors['confirmationMotDePasse'] = "La confirmation du mot de passe est obligatoire.";
}

// Si aucune erreur détectée
if (empty(array_filter($errors))) {
try {
// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=bdd_projet_web', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Vérification si le pseudo ou l'email existe déjà
$stmt = $pdo->prepare("SELECT uti_id FROM t_utilisateur_uti WHERE uti_pseudo = :pseudo OR uti_email = :email");
$stmt->execute(['pseudo' => $pseudo, 'email' => $email]);
if ($stmt->fetch()) {
$errors['general'] = "Ce pseudo ou email est déjà utilisé.";
} else {
// Hachage du mot de passe
$hashedPassword = password_hash($motDePasse, PASSWORD_BCRYPT);

// Insertion des données
$stmt = $pdo->prepare("INSERT INTO t_utilisateur_uti (uti_pseudo, uti_email, uti_motdepasse) VALUES (:pseudo, :email, :password)");
$stmt->execute(['pseudo' => $pseudo, 'email' => $email, 'password' => $hashedPassword]);

// Formulaire soumis avec succès
$formSubmitted = true;
}
} catch (PDOException $e) {
$errors['general'] = "Une erreur est survenue lors de l'inscription.";
}
}
}

// Définition du titre de la page et de la méta-description
$pageTitre = "Inscription";
$metaDescription = "Page d'inscription pour créer un compte.";

require_once 'header.php';
?>

<h1>Inscription</h1>

<?php if ($formSubmitted) : ?>
    <p class="success-message">Votre compte a bien été créé ! Vous pouvez maintenant vous connecter.</p>
<?php endif; ?>

<form method="post">
    <div>
        <label for="pseudo">Pseudo* :</label>
        <input type="text" id="pseudo" name="inscription_pseudo" value="<?php echo htmlspecialchars($pseudo); ?>" required>
        <?php if (!empty($errors['pseudo'])) : ?>
            <span class="error-message"><?php echo $errors['pseudo']; ?></span>
        <?php endif; ?>
    </div>
    <div>
        <label for="email">Email* :</label>
        <input type="email" id="email" name="inscription_email" value="<?php echo htmlspecialchars($email); ?>" required>
        <?php if (!empty($errors['email'])) : ?>
            <span class="error-message"><?php echo $errors['email']; ?></span>
        <?php endif; ?>
    </div>
    <div>
        <label for="motDePasse">Mot de passe* :</label>
        <input type="password" id="motDePasse" name="inscription_motDePasse" required>
        <?php if (!empty($errors['motDePasse'])) : ?>
            <span class="error-message"><?php echo $errors['motDePasse']; ?></span>
        <?php endif; ?>
    </div>
    <div>
        <label for="confirmationMotDePasse">Confirmation du mot de passe* :</label>
        <input type="password" id="confirmationMotDePasse" name="inscription_motDePasse_confirmation" required>
        <?php if (!empty($errors['confirmationMotDePasse'])) : ?>
            <span class="error-message"><?php echo $errors['confirmationMotDePasse']; ?></span>
        <?php endif; ?>
    </div>
    <button type="submit">S'inscrire</button>
</form>

<?php if (!empty($errors['general'])) : ?>
    <p class="error-message"><?php echo $errors['general']; ?></p>
<?php endif; ?>

<?php require_once 'footer.php'; ?>