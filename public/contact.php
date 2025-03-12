<?php
// Initialisation des variables
$nom = $email = '';
$errors = [];
$formSubmitted = false;

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validation du champ "Nom"
    if (empty($_POST['nom'])) {
        $errors['nom'] = "Le nom est obligatoire.";
    } elseif (strlen($_POST['nom']) < 2 || strlen($_POST['nom']) > 255) {
        $errors['nom'] = "Le nom doit contenir entre 2 et 255 caractères.";
    } else {
        $nom = htmlspecialchars($_POST['nom']);
    }

    // Validation du champ "Email"
    if (empty($_POST['email'])) {
        $errors['email'] = "L'email est obligatoire.";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "L'email n'est pas valide.";
    } else {
        $email = htmlspecialchars($_POST['email']);
    }

    // Si aucune erreur détectée
    if (empty($errors)) {
        $formSubmitted = true;
        $nom = $email = ''; // Réinitialisation des champs
    }
}

// Définition du titre de la page et de la méta-description
$pageTitre = "Contact";
$metaDescription = "Formulaire de contact avec validation côté serveur.";

// Inclusion de l'en-tête commun
require_once 'header.php';
?>

<h1>Nous contacter</h1>

<?php if ($formSubmitted) : ?>
    <p class="success-message">Le formulaire a bien été envoyé !</p>
<?php endif; ?>

<form method="post">
    <div>
        <label for="nom">Nom* :</label>
        <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($nom); ?>" required>
        <?php if (isset($errors['nom'])) : ?>
            <span class="error-message"><?php echo $errors['nom']; ?></span>
        <?php endif; ?>
    </div>
    <div>
        <label for="email">Email* :</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
        <?php if (isset($errors['email'])) : ?>
            <span class="error-message"><?php echo $errors['email']; ?></span>
        <?php endif; ?>
    </div>
    <button type="submit">Envoyer</button>
</form>

<?php if (!empty($errors)) : ?>
    <p class="error-message">Le formulaire n'a pas été envoyé !</p>
<?php endif; ?>

<?php
// Inclusion du pied de page commun
require_once 'footer.php';
?>
