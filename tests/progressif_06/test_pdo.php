<?php
try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=test_db", "root", "");
    echo "✅ Connexion réussie avec PDO MySQL !";
} catch (PDOException $e) {
    echo "❌ Erreur de connexion : " . $e->getMessage();
}
?>
