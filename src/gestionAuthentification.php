<?php
//Vérifiez si une session est déjà active avant de l'initialiser
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Démarre la session si elle n'est pas déjà active
}

// Fonction pour obtenir la connexion à la base de données
function getConnexion() {
    static $conn = null;

    $user = "root"; // db_user
    $pass = ""; // db_pass
    if ($conn === null) {
        try {
            // Connexion sécurisée à la base de données avec PDO pour MySQL
            $conn = new PDO('mysql:host=localhost;dbname=bdd_projet_web;charset=utf8', $user, $pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Gestion des erreurs
        } catch (PDOException $e) {
            // En cas d'erreur de connexion, on arrête l'exécution et affiche l'erreur
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }
    return $conn;
}

// Fonction pour vérifier si l'utilisateur est connecté
function est_connecte(): bool {
    return isset($_SESSION['uti_id']); // Vérifie si l'ID de l'utilisateur est dans la session
}

// Fonction pour se connecter à l'utilisateur
function seConnecter($email, $password) {
    $conn = getConnexion(); // Récupère la connexion

    // Préparation de la requête SQL pour récupérer l'utilisateur avec l'email
    $stmt = $conn->prepare('SELECT * FROM t_utilisateur_uti WHERE uti_email = :email');
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    // Récupération de l'utilisateur
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si l'utilisateur existe et que le mot de passe est valide
    if ($user && password_verify($password, $user['uti_motdepasse'])) {
        connecter_utilisateur($user['uti_id']); // Connexion réussie
        return $user; // Retourne les informations de l'utilisateur
    }
    return false; // Mauvais identifiants ou utilisateur non trouvé
}

// Fonction pour inscrire un nouvel utilisateur
function inscrireUtilisateur($pseudo, $email, $password): false|string
{
    $conn = getConnexion();

    // Vérifier si l'email est déjà utilisé
    $stmt = $conn->prepare('SELECT * FROM t_utilisateur_uti WHERE uti_email =:email');
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingUser ) {
        return false; // Email déjà utilisé
    }

    // Hachage du mot de passe
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insertion de l'utilisateur
    $stmt = $conn->prepare('INSERT INTO t_utilisateur_uti (uti_pseudo, uti_email, uti_motdepasse) VALUES (:pseudo, :email, :motdepasse)');
    $stmt->bindParam(':pseudo', $pseudo);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':motdepasse', $hashedPassword);

    if ($stmt->execute()) {
        return $conn->lastInsertId(); // Retourne l'ID de l'utilisateur inscrit
    }
    return false; // Échec de l'insertion
}

// Fonction pour connecter l'utilisateur
function connecter_utilisateur($userId): void {
    $_SESSION['uti_id'] = $userId; // Stocke l'ID de l'utilisateur dans la session
}

// Fonction pour déconnecter l'utilisateur
function deconnecter_utilisateur(): void {
    // Vérifie si la session est démarrée
    if (session_status() === PHP_SESSION_ACTIVE) {
        // Détruire toutes les variables de session
        $_SESSION = array();

        // Si vous souhaitez détruire complètement la session, appelez session_destroy()
        session_destroy();
    }
}

/**
 * Met à jour les informations de l'utilisateur dans la base de données.
 *
 * @param int $userId L'ID de l'utilisateur.
 * @param string $pseudo Le nouveau pseudo.
 * @param string $email Le nouvel email.
 * @param string|null $nomComplet Le nouveau nom complet (facultatif).
 * @return bool True si la mise à jour réussit, sinon false.
 */
function modifierProfil($userId, $pseudo, $email, $nomComplet = null): bool {
    $conn = getConnexion();

    // Vérifier si le pseudo ou l'email existe déjà pour un autre utilisateur
    $stmt = $conn->prepare('SELECT * FROM t_utilisateur_uti WHERE (uti_pseudo = :pseudo OR uti_email = :email) AND uti_id != :id');
    $stmt->bindParam(':pseudo', $pseudo);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':id', $userId);
    $stmt->execute();

    if ($stmt->fetch(PDO::FETCH_ASSOC)) {
        return false; // Le pseudo ou l'email est déjà utilisé par un autre utilisateur
    }

    // Mettre à jour les informations de l'utilisateur
    $stmt = $conn->prepare('UPDATE t_utilisateur_uti SET uti_pseudo = :pseudo, uti_email = :email, uti_nom_complet = :nom_complet WHERE uti_id = :id');
    $stmt->bindParam(':pseudo', $pseudo);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':nom_complet', $nomComplet);
    $stmt->bindParam(':id', $userId);

    return $stmt->execute();
}

/**
 * Change le mot de passe de l'utilisateur.
 *
 * @param int $userId L'ID de l'utilisateur.
 * @param string $ancienMotDePasse L'ancien mot de passe.
 * @param string $nouveauMotDePasse Le nouveau mot de passe.
 * @return bool True si le changement réussit, sinon false.
 */
function changerMotDePasse($userId, $ancienMotDePasse, $nouveauMotDePasse): bool {
    $conn = getConnexion();

    // Récupérer le mot de passe actuel de l'utilisateur
    $stmt = $conn->prepare('SELECT uti_motdepasse FROM t_utilisateur_uti WHERE uti_id = :id');
    $stmt->bindParam(':id', $userId);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier que l'ancien mot de passe est correct
    if (!$user || !password_verify($ancienMotDePasse, $user['uti_motdepasse'])) {
        return false; // L'ancien mot de passe est incorrect
    }

    // Hacher le nouveau mot de passe et le mettre à jour
    $hashedPassword = password_hash($nouveauMotDePasse, PASSWORD_BCRYPT);
    $stmt = $conn->prepare('UPDATE t_utilisateur_uti SET uti_motdepasse = :mot_de_passe WHERE uti_id = :id');
    $stmt->bindParam(':mot_de_passe', $hashedPassword);
    $stmt->bindParam(':id', $userId);

    return $stmt->execute();
}

/**
 * Supprime le compte de l'utilisateur.
 *
 * @param int $userId L'ID de l'utilisateur.
 * @return bool True si la suppression réussit, sinon false.
 */
function supprimerCompte($userId): bool {
    $conn = getConnexion();

    // Supprimer l'utilisateur de la base de données
    $stmt = $conn->prepare('DELETE FROM t_utilisateur_uti WHERE uti_id = :id');
    $stmt->bindParam(':id', $userId);

    return $stmt->execute();
}

?>