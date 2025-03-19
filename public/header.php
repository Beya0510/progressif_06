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
    <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Mon Projet'; ?></title>
</head>
<body>
<main>
    <!-- Bouton hamburger -->
    <div id="hamburger-menu" aria-label="Afficher le menu" aria-expanded="false">
        <span></span>
        <span></span>
        <span></span>
    </div>

    <!-- Menu de navigation -->
    <nav id="main-menu" class="hidden">
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="contact.php">Contact</a></li>
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

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
</body>
</html>