<?php
// Inclusion du gestionnaire d'authentification
require_once '../src/gestionAuthentification.php';

// Vérifie si l'utilisateur est connecté
$estConnecte = est_connecte();

// Définition du titre et de la méta-description
$title = isset($pageTitre) ? htmlspecialchars($pageTitre) : "Mon Site";
$description = isset($metaDescription) ? htmlspecialchars($metaDescription) : "Bienvenue sur mon site web.";

// Liste des pages accessibles dans le menu
$pages = [
    'Accueil' => 'index.php',
    'Contact' => 'contact.php'
];

if ($estConnecte) {
    $pages['Profil'] = 'profil.php';
    $pages['Déconnexion'] = 'connexion.php?action=deconnexion';
} else {
    $pages['Inscription'] = 'inscription.php';
    $pages['Connexion'] = 'connexion.php';
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $description; ?>">
    <title><?php echo $title; ?></title>
    <!-- Lien vers le fichier CSS -->
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<header>
    <nav>
        <ul>
            <?php
            $currentPage = basename($_SERVER['PHP_SELF']);
            foreach ($pages as $titre => $url) {
                $activeClass = ($currentPage === $url || ($currentPage === 'connexion.php' && strpos($url, 'action=deconnexion'))) ? ' class="active"' : '';
                echo "<li><a href=\"$url\"$activeClass>$titre</a></li>";
            }
            ?>
        </ul>
    </nav>
</header>