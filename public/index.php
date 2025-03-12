<?php
// Inclusion du gestionnaire d'authentification
require_once 'header.php';
?>

    <h1>Bienvenue sur notre site</h1>

<?php if (est_connecte()) : ?>
    <p>Bienvenue, vous êtes connecté !</p>
<?php else : ?>
    <p>Connectez-vous ou inscrivez-vous pour profiter de nos services.</p>
<?php endif; ?>

<?php require_once 'footer.php'; ?>