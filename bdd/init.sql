-- Création de la base de données
CREATE DATABASE bdd_projet_web;

USE bdd_projet_web;

-- Création de la table des utilisateurs
CREATE TABLE t_utilisateur_uti (
                                   uti_id INT AUTO_INCREMENT PRIMARY KEY, -- ID utilisateur auto-incrémenté
                                   uti_pseudo VARCHAR(255) NOT NULL UNIQUE, -- Pseudo unique
                                   uti_email VARCHAR(255) NOT NULL UNIQUE, -- Email unique
                                   uti_motdepasse VARCHAR(255) NOT NULL -- Mot de passe haché
);


SELECT * FROM bdd_projet_web.t_utilisateur_uti;