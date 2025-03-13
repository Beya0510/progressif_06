<?php
// Inclure le gestionnaire d'authentification
require_once 'src/gestionAuthentification.php';

// Vérifier si l'utilisateur est connecté et le déconnecter
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

