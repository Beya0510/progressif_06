<?php
// Inclusion du fichier de gestion d'authentification pour pouvoir utiliser la fonction 'est_connecte()'
require_once '../src/gestionAuthentification.php';
?>
<?php
$pageTitle = "Accueil";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<main>
<!-- Bouton hamburger -->
<div id="hamburger-menu">
    <span></span>
    <span></span>
    <span></span>
</div>

<!-- Menu de navigation -->
<nav id="main-menu">
    <ul>
        <li><a href="index.php">Accueil</a></li>
        <li><a href="../public/contact.php">Contact</a></li>
        <li><a href="profil.php">Profil</a></li>
        <!-- Vérifie si l'utilisateur est connecté -->
        <?php if (est_connecte()) : ?>
            <li><a href="deconnexion.php">Déconnexion</a></li>
        <?php else : ?>
            <li><a href="connexion.php">Connexion</a></li>
            <li><a href="inscription.php">Inscription</a></li>
        <?php endif; ?>
    </ul>
</nav>
</main>
<!-- Importation de jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Importation de votre script menu.js -->
<script src="../assets/Js/menu.js"></script>
</body>
</html>