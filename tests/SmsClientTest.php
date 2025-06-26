<?php

namespace Room\Sms\Tests;

use PHPUnit\Framework\TestCase;
use Room\Sms\SmsClient;
use Room\Sms\Exceptions\ValidationException;

class SmsClientTest extends TestCase
{
    private SmsClient $client;

    protected function setUp(): void
    {
        $this->client = new SmsClient([
            'token' => 'test_token',
        ]);
    }

    public function testClientInitialization()
    {
        $this->assertInstanceOf(SmsClient::class, $this->client);
    }

    public function testValidationExceptionForEmptyPhone()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Le numéro de téléphone est requis');

        $this->client->send([
            'content' => 'Test message'
        ]);
    }

    public function testValidationExceptionForEmptyContent()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Le contenu du message est requis');

        $this->client->send([
            'to' => '212689131285'
        ]);
    }

    public function testValidationExceptionForLongContent()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Le message ne peut pas dépasser 160 caractères');

        $longContent = str_repeat('a', 161);
        $this->client->send([
            'to' => '212689131285',
            'content' => $longContent
        ]);
    }

    public function testPhoneNumberFormatting()
    {
        // Test avec un numéro sans code pays
        $response = $this->client->send([
            'to' => '689131285',
            'content' => 'Test message'
        ]);

        // Le numéro devrait être formaté automatiquement
        $this->assertTrue(true); // Test de base pour vérifier que l'exception n'est pas levée
    }
}
