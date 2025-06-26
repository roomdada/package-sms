<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Room\Sms\SmsClient;

// Configuration du client avec votre token Letexto
$client = new SmsClient([
    'token' => 'aeca24110a548d582c1bbdd0ef8feddf',
    'base_url' => 'https://apis.letexto.com/v1'
]);

try {
    // Envoi d'un SMS simple (exemple sécurisé)
    $response = $client->send([
        'to' => '2250100000000',
        'content' => 'Votre code de vérification est: 123456',
        'from' => 'MonApp'
    ]);

    echo "SMS envoyé avec succès!\n";
    echo "Réponse: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";

} catch (Exception $e) {
    echo "Erreur: " . $e->getMessage() . "\n";
}
