<?php
// Démarre la session si elle n'est pas déjà démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Fonction pour connecter un utilisateur.
 *
 * @param int $userId ID de l'utilisateur.
 */
function connecter_utilisateur($userId) {
    $_SESSION['utilisateurId'] = $userId;
    session_regenerate_id(true); // Sécurise la session en régénérant son ID
}

/**
 * Vérifie si un utilisateur est connecté.
 *
 * @return bool True si connecté, False sinon.
 */
function est_connecte() {
    return isset($_SESSION['utilisateurId']);
}

/**
 * Déconnecte l'utilisateur en supprimant sa session.
 */
function deconnecter_utilisateur() {
    if (isset($_SESSION['utilisateurId'])) {
        unset($_SESSION['utilisateurId']);
    }
    session_destroy(); // Détruit toute la session
}
