<?php
// Inclusion du fichier de gestion d'authentification pour pouvoir utiliser la fonction 'est_connecte()'
// Le fichier 'gestionAuthentification.php' est dans le dossier 'src', donc on ajuste le chemin
require_once '../src/gestionAuthentification.php'; // Chemin correct si le fichier est dans 'src' dans le dossier racine
?>

<header>
    <!-- Navigation principale -->
    <nav>
        <ul>
            <!-- Lien vers la page d'accueil -->
            <li><a href="index.php">Accueil</a></li>

            <!-- Lien vers la page de contact -->
            <li><a href="contact.php">Contact</a></li>

            <!-- Lien vers le profil de l'utilisateur -->
            <li><a href="profil.php">Profil</a></li>

            <!-- Vérifie si l'utilisateur est connecté -->
            <?php if (est_connecte()) : ?>
                <!-- Si connecté, affichage du lien de déconnexion -->
                <li><a href="deconnexion.php">Déconnexion</a></li>
            <?php else : ?>
                <!-- Si non connecté, affichage du lien de connexion -->
                <li><a href="connexion.php">Connexion</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
