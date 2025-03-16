<?php
// Fonction pour obtenir la connexion à la base de données
function getConnexion() {
    static $conn = null;

    if ($conn === null) {
        try {
            // Connexion sécurisée à la base de données avec PDO
            $conn = new PDO('mysql:host=localhost;dbname=bdd_projet_web', 'votre_utilisateur', 'votre_mot_de_passe');
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
    return isset($_SESSION['utilisateurId']); // Vérifie si l'ID de l'utilisateur est dans la session
}

// Fonction pour se connecter à l'utilisateur
function seConnecter($email, $password) {
    $conn = getConnexion(); // Récupère la connexion

    // Préparation de la requête SQL pour récupérer l'utilisateur avec l'email
    $stmt = $conn->prepare('SELECT * FROM utilisateurs WHERE email = :email');
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    // Récupération de l'utilisateur
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si l'utilisateur existe et que le mot de passe est valide
    if ($user && password_verify($password, $user['mot_de_passe'])) {
        return $user; // Connexion réussie
    }
    return false; // Mauvais identifiants ou utilisateur non trouvé
}

// Fonction pour inscrire un nouvel utilisateur
function inscrireUtilisateur($email, $password): int|bool {
    $conn = getConnexion(); // Récupère la connexion

    // Vérifier si l'email est déjà utilisé
    $stmt = $conn->prepare('SELECT * FROM utilisateurs WHERE email = :email');
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $existingUser  = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si l'email est déjà pris, retourne 'false'
    if ($existingUser ) {
        return false;
    }

    // Hachage du mot de passe avant l'insertion dans la base de données
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Préparation de la requête d'insertion dans la base de données
    $stmt = $conn->prepare('INSERT INTO utilisateurs (email, mot_de_passe) VALUES (:email, :mot_de_passe)');
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':mot_de_passe', $hashedPassword);

    // Exécution de la requête d'insertion
    if ($stmt->execute()) {
        return $conn->lastInsertId(); // Retourne l'ID de l'utilisateur inscrit
    }
    return false; // Si l'insertion échoue
}

// Fonction pour connecter l'utilisateur
function connecter_utilisateur($userId): void {
    $_SESSION['utilisateurId'] = $userId; // Stocke l'ID de l'utilisateur dans la session
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

