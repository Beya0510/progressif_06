<?php
session_start(); // Démarre la session si elle n'est pas déjà démarrée
include 'header.php';
require_once '../src/gestionAuthentification.php';

// Vérifie si l'utilisateur est connecté
if (est_connecte()) {
    // Déconnexion de l'utilisateur
    deconnecter_utilisateur();
    header('Location: index.php'); // Redirection vers la page d'accueil
    exit;
} else {
    // Si l'utilisateur n'est pas connecté, redirection vers la page de connexion
    header('Location: connexion.php');
    exit;
}
?>