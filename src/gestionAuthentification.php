<?php
// Connexion à la base de données
function seConnecter($email, $password) {
    try {
        // Connexion sécurisée à la base de données avec PDO
        $conn = new PDO('mysql:host=localhost;dbname=votre_db', 'votre_utilisateur', 'votre_mot_de_passe');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Gestion des erreurs en cas de problème avec la base
    } catch (PDOException $e) {
        // En cas d'erreur de connexion, on arrête l'exécution et affiche l'erreur
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }

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
function inscrireUtilisateur($email, $password) {
    try {
        // Connexion sécurisée à la base de données avec PDO
        $conn = new PDO('mysql:host=localhost;dbname=votre_db', 'votre_utilisateur', 'votre_mot_de_passe');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Gestion des erreurs en cas de problème avec la base
    } catch (PDOException $e) {
        // En cas d'erreur de connexion, on arrête l'exécution et affiche l'erreur
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }

    // Vérifier si l'email est déjà utilisé dans la base de données
    $stmt = $conn->prepare('SELECT * FROM utilisateurs WHERE email = :email');
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si un utilisateur avec cet email existe déjà, retour 'false'
    if ($existingUser) {
        return false; // L'email est déjà pris
    }

    // Hachage du mot de passe avant l'insertion dans la base de données pour plus de sécurité
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Préparation de la requête d'insertion dans la base de données
    $stmt = $conn->prepare('INSERT INTO utilisateurs (email, mot_de_passe) VALUES (:email, :mot_de_passe)');
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':mot_de_passe', $hashedPassword);

    // Exécution de la requête d'insertion
    if ($stmt->execute()) {
        return $conn->lastInsertId(); // Retourne l'ID de l'utilisateur inscrit
    }
    return false; // Si l'insertion échoue, retourne 'false'
}
?>
