<?php
// Inclusion du fichier de gestion d'authentification pour pouvoir utiliser la fonction 'est_connecte()'
require_once '../src/gestionAuthentification.php';

$pageTitle = "Acceuil";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) : $pageTitle; ?></title>
</head>
<body>
<main>
    <!-- Bouton hamburger -->
    <button id="hamburger-button" aria-label="Ouvrir le menu" aria-expanded="false">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
    </button>
    <!--- Menu de navigation -->
    <nav id="hamburger-menu">
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="contact.php">Contact</a></li>
            <?php if (est_connecte()): ?>
                <li><a href="profil.php">Profil</a></li>
                <li><a href="deconnexion.php">Déconnexion</a></li>
            <?php else: ?>
                <li><a href="connexion.php">Connexion</a></li>
                <li><a href="inscription.php">Inscription</a></li>
            <?php endif; ?>
        </ul>
    </nav>

</main>
<!-- Importation de jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

<script src="../assets/Js/menu.js" defer></script>

</body>
</html>