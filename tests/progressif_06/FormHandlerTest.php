<?php

namespace progressif_06;

use FormHandler;
use PHPUnit\Framework\TestCase;

class FormHandlerTest extends TestCase
{
    public function validateMatchReturnsNullWhenValuesMatch()
    {
        $this->assertNull(FormHandler::validateMatch('value1', 'value1'));
    }

    public function validateMatchReturnsErrorWhenValuesDoNotMatch()
    {
        $this->assertEquals('Les valeurs ne correspondent pas.', FormHandler::validateMatch('value1', 'value2'));
    }

    public function sanitizeInputTrimsAndEscapesInput()
    {
        $this->assertEquals('test', FormHandler::sanitizeInput('  test  '));
        $this->assertEquals('&lt;script&gt;', FormHandler::sanitizeInput('<script>'));
    }

    public function validatePasswordReturnsNullForValidPassword()
    {
        $this->assertNull(FormHandler::validatePassword('Valid1!'));
    }

    public function validatePasswordReturnsErrorForEmptyPassword()
    {
        $this->assertEquals('Le mot de passe est obligatoire.', FormHandler::validatePassword(''));
    }

    public function validatePasswordReturnsErrorForShortPassword()
    {
        $this->assertEquals('Le mot de passe doit contenir entre 8 et 72 caractères.', FormHandler::validatePassword('Short1!'));
    }

    public function validatePasswordReturnsErrorForPasswordWithoutUppercase()
    {
        $this->assertEquals('Le mot de passe doit contenir au moins une lettre majuscule.', FormHandler::validatePassword('valid1!'));
    }

    public function validatePasswordReturnsErrorForPasswordWithoutLowercase()
    {
        $this->assertEquals('Le mot de passe doit contenir au moins une lettre minuscule.', FormHandler::validatePassword('VALID1!'));
    }

    public function validatePasswordReturnsErrorForPasswordWithoutDigit()
    {
        $this->assertEquals('Le mot de passe doit contenir au moins un chiffre.', FormHandler::validatePassword('Valid!'));
    }

    public function validatePasswordReturnsErrorForPasswordWithoutSpecialCharacter()
    {
        $this->assertEquals('Le mot de passe doit contenir au moins un caractère spécial.', FormHandler::validatePassword('Valid1'));
    }

    public function validateEmailReturnsNullForValidEmail()
    {
        $this->assertNull(FormHandler::validateEmail('test@example.com'));
    }

    public function validateEmailReturnsErrorForInvalidEmail()
    {
        $this->assertEquals('L\'email n\'est pas valide.', FormHandler::validateEmail('invalid-email'));
    }

    public function validateEmailReturnsErrorForEmptyEmailWhenRequired()
    {
        $this->assertEquals('Ce champ est obligatoire.', FormHandler::validateEmail('', true));
    }

    public function validateLengthReturnsNullForValidLength()
    {
        $this->assertNull(FormHandler::validateLength('valid', 3, 10));
    }

    public function validateLengthReturnsErrorForShortValue()
    {
        $this->assertEquals('La valeur doit contenir entre 3 et 10 caractères.', FormHandler::validateLength('no', 3, 10));
    }

    public function validateLengthReturnsErrorForLongValue()
    {
        $this->assertEquals('La valeur doit contenir entre 3 et 10 caractères.', FormHandler::validateLength('this is too long', 3, 10));
    }
}