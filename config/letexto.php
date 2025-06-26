<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Letexto SMS Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration pour l'API Letexto SMS
    |
    */

    'token' => env('LETEXTO_TOKEN', ''),

    'base_url' => env('LETEXTO_BASE_URL', 'https://apis.letexto.com/v1'),

    'sender' => env('LETEXTO_SENDER', 'MonApp'),

    'timeout' => env('LETEXTO_TIMEOUT', 30),

    /*
    |--------------------------------------------------------------------------
    | Configuration par défaut
    |--------------------------------------------------------------------------
    |
    | Paramètres par défaut pour l'envoi de SMS
    |
    */

    'defaults' => [
        'from' => env('LETEXTO_SENDER', 'MonApp'),
        'timeout' => env('LETEXTO_TIMEOUT', 30),
    ],

    /*
    |--------------------------------------------------------------------------
    | Logging
    |--------------------------------------------------------------------------
    |
    | Activer le logging des SMS envoyés
    |
    */

    'logging' => env('LETEXTO_LOGGING', false),

    'log_channel' => env('LETEXTO_LOG_CHANNEL', 'daily'),
];
