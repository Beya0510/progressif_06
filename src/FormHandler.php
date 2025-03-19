<?php
class FormHandler {

    /**
     * Valide une valeur pour qu'elle contienne un nombre de caractères spécifique.
     *
     * @param string $value Valeur à valider.
     * @param int $minLength Longueur minimale autorisée.
     * @param int $maxLength Longueur maximale autorisée.
     * @return string|null Message d'erreur ou null si valide.
     */
    public static function validateLength($value, $minLength, $maxLength): ?string
    {
        if (strlen($value) < $minLength || strlen($value) > $maxLength) {
            return "La valeur doit contenir entre $minLength et $maxLength caractères.";
        }
        return null;
    }

    /**
     * Valide un email.
     *
     * @param string $email Email à valider.
     * @param bool $required Indique si le champ est obligatoire.
     * @return string|null Message d'erreur ou null si valide.
     */
    public static function validateEmail(string $email, bool $required = true): ?string
    {
        if ($required && empty($email)) {
            return "Ce champ est obligatoire.";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "L'email n'est pas valide.";
        }
        return null;
    }

    /**
     * Valide un mot de passe.
     *
     * @param string $password Mot de passe à valider.
     * @param int $minLength Longueur minimale du mot de passe.
     * @param int $maxLength Longueur maximale du mot de passe.
     * @return string|null Message d'erreur ou null si valide.
     */
    public static function validatePassword(string $password, int $minLength = 8, int $maxLength = 72): ?string
    {
        if (empty($password)) {
            return "Le mot de passe est obligatoire.";
        }
        if (strlen($password) < $minLength || strlen($password) > $maxLength) {
            return "Le mot de passe doit contenir entre $minLength et $maxLength caractères.";
        }

        // Vérification de la force du mot de passe (au moins une majuscule, un chiffre et un caractère spécial)
        if (!preg_match('/[A-Z]/', $password)) {
            return "Le mot de passe doit contenir au moins une lettre majuscule.";
        }
        if (!preg_match('/[a-z]/', $password)) {
            return "Le mot de passe doit contenir au moins une lettre minuscule.";
        }
        if (!preg_match('/\d/', $password)) {
            return "Le mot de passe doit contenir au moins un chiffre.";
        }
        if (!preg_match('/[^a-zA-Z0-9]/', $password)) {
            return "Le mot de passe doit contenir au moins un caractère spécial.";
        }

        return null;
    }

    /**
     * Vérifie si deux valeurs sont identiques (pour confirmation de mot de passe).
     *
     * @param string $value1 Première valeur.
     * @param string $value2 Seconde valeur.
     * @return string|null Message d'erreur ou null si elles correspondent.
     */
    public static function validateMatch(string $value1, string $value2): ?string
    {
        if ($value1 !== $value2) {
            return "Les valeurs ne correspondent pas.";
        }
        return null;
    }

    /**
     * Assainit une valeur pour éviter les attaques XSS.
     *
     * @param string $value Valeur à assainir.
     * @return string Valeur assainie.
     */
    public static function sanitizeInput(string $value): string
    {
        // htmlspecialchars() évite les attaques XSS en échappant les caractères spéciaux
        return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
    }
}