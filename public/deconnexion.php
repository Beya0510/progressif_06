<?php
include 'header.php';
require_once 'src/gestionAuthentification.php';

// Vérifie si l'utilisateur est connecté, si oui, on le déconnecte
if (est_connecte()) {
    deconnecter_utilisateur();
    header('Location: index.php'); // Redirection vers la page d'accueil
    exit;
} else {
    // Si l'utilisateur n'est pas connecté, redirection vers la page de connexion
    header('Location: connexion.php');
    exit;
}
?>

