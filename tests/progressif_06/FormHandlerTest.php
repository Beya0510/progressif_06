<?php

namespace progressif_06;

use FormHandler;
use PHPUnit\Framework\TestCase;

class FormHandlerTest extends TestCase
{
    public function validateMatchReturnsNullWhenValuesMatch(): void
    {
        $this->assertNull(FormHandler::validateMatch('value1', 'value1'));
    }

    public function validateMatchReturnsErrorWhenValuesDoNotMatch(): void
    {
        $this->assertEquals('Les valeurs ne correspondent pas.', FormHandler::validateMatch('value1', 'value2'));
    }

    public function sanitizeInputTrimsAndEscapesInput(): void
    {
        $this->assertEquals('test', FormHandler::sanitizeInput('  test  '));
        $this->assertEquals('&lt;script&gt;', FormHandler::sanitizeInput('<script>'));
    }

    public function validatePasswordReturnsNullForValidPassword(): void
    {
        $this->assertNull(FormHandler::validatePassword('Valid1!'));
    }

    public function validatePasswordReturnsErrorForEmptyPassword(): void
    {
        $this->assertEquals('Le mot de passe est obligatoire.', FormHandler::validatePassword(''));
    }

    public function validatePasswordReturnsErrorForShortPassword(): void
    {
        $this->assertEquals('Le mot de passe doit contenir entre 8 et 72 caractères.', FormHandler::validatePassword('Short1!'));
    }

    public function validatePasswordReturnsErrorForPasswordWithoutUppercase(): void
    {
        $this->assertEquals('Le mot de passe doit contenir au moins une lettre majuscule.', FormHandler::validatePassword('valid1!'));
    }

    public function validatePasswordReturnsErrorForPasswordWithoutLowercase(): void
    {
        $this->assertEquals('Le mot de passe doit contenir au moins une lettre minuscule.', FormHandler::validatePassword('VALID1!'));
    }

    public function validatePasswordReturnsErrorForPasswordWithoutDigit(): void
    {
        $this->assertEquals('Le mot de passe doit contenir au moins un chiffre.', FormHandler::validatePassword('Valid!'));
    }

    public function validatePasswordReturnsErrorForPasswordWithoutSpecialCharacter(): void
    {
        $this->assertEquals('Le mot de passe doit contenir au moins un caractère spécial.', FormHandler::validatePassword('Valid1'));
    }

    public function validateEmailReturnsNullForValidEmail(): void
    {
        $this->assertNull(FormHandler::validateEmail('test@example.com'));
    }

    public function validateEmailReturnsErrorForInvalidEmail(): void
    {
        $this->assertEquals('L\'email n\'est pas valide.', FormHandler::validateEmail('invalid-email'));
    }

    public function validateEmailReturnsErrorForEmptyEmailWhenRequired(): void
    {
        $this->assertEquals('Ce champ est obligatoire.', FormHandler::validateEmail('', true));
    }

    public function validateLengthReturnsNullForValidLength(): void
    {
        $this->assertNull(FormHandler::validateLength('valid', 3, 10));
    }

    public function validateLengthReturnsErrorForShortValue(): void
    {
        $this->assertEquals('La valeur doit contenir entre 3 et 10 caractères.', FormHandler::validateLength('no', 3, 10));
    }

    public function validateLengthReturnsErrorForLongValue(): void
    {
        $this->assertEquals('La valeur doit contenir entre 3 et 10 caractères.', FormHandler::validateLength('this is too long', 3, 10));
    }
}