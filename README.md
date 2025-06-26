# Letexto SMS Package

Package PHP pour l'envoi de SMS via l'API Letexto.

**Développé par :** DA Sie Roger (dsieroger@gmail.com)

## Installation

```bash
composer require room/letexto-sms-package:^1.0
```

## Configuration

```php
use Room\Sms\SmsClient;

$client = new SmsClient([
    'token' => 'votre_token_api',
    'base_url' => 'https://apis.letexto.com/v1'
]);
```

## Utilisation

### Envoi d'un SMS simple

```php
$response = $client->send([
    'to' => '2250100000000',
    'content' => 'Votre code de vérification est: 123456',
    'from' => 'MonApp'
]);
```

### Envoi d'un SMS avec expéditeur personnalisé

```php
$response = $client->send([
    'to' => '2250200000000',
    'content' => 'Message de test',
    'from' => 'TestApp'
]);
```

### Envoi en masse

```php
$response = $client->sendBulk([
    'to' => ['2250100000000', '2250200000000'],
    'content' => 'Message en masse',
    'from' => 'MonApp'
]);
```

## Intégration Laravel

### Installation dans Laravel

```bash
composer require room/letexto-sms-package:^1.0
```

### Configuration Laravel

#### Option 1 : Publier le fichier de configuration (recommandé)

```bash
php artisan vendor:publish --provider="Room\Sms\SmsServiceProvider"
```

#### Option 2 : Configuration manuelle

Créez le fichier `config/letexto.php` :

```php
<?php

return [
    'token' => env('LETEXTO_TOKEN', ''),
    'base_url' => env('LETEXTO_BASE_URL', 'https://apis.letexto.com/v1'),
    'sender' => env('LETEXTO_SENDER', 'MonApp'),
    'timeout' => env('LETEXTO_TIMEOUT', 30),
    'logging' => env('LETEXTO_LOGGING', false),
];
```

Dans votre fichier `.env` :

```env
LETEXTO_TOKEN=votre_token_ici
LETEXTO_BASE_URL=https://apis.letexto.com/v1
LETEXTO_SENDER=MonApp
LETEXTO_TIMEOUT=30
LETEXTO_LOGGING=false
```

### Utilisation dans un Controller

```php
<?php

namespace App\Http\Controllers;

use Room\Sms\SmsClient;

class SmsController extends Controller
{
    public function sendSms(SmsClient $smsClient)
    {
        $response = $smsClient->send([
            'to' => '2250100000000',
            'content' => 'Votre code de vérification est: 123456',
            'from' => config('letexto.sender')
        ]);

        return response()->json($response);
    }
}
```

### Utilisation avec Injection de Dépendance

```php
public function sendSms(SmsClient $smsClient)
{
    $response = $smsClient->send([
        'to' => '2250100000000',
        'content' => 'Votre code: 123456',
        'from' => config('letexto.sender')
    ]);

    return response()->json($response);
}
```

**📖 [Guide complet d'intégration Laravel](docs/laravel-integration.md)**

## Fonctionnalités

- ✅ Envoi de SMS simple
- ✅ Envoi en masse
- ✅ Gestion des erreurs
- ✅ Validation des numéros de téléphone
- ✅ Support des caractères spéciaux
- ✅ Rapports de livraison
- ✅ Compatible avec l'API Letexto
- ✅ Intégration Laravel native

## Exemple d'API Letexto

```bash
curl --location 'https://apis.letexto.com/v1/messages/send?from=MonApp&to=2250100000000&content=Votre%20code%20de%20verification&token=votre_token'
```

## Tests

```bash
composer test
```

## Licence

MIT License - Développé par DA Sie Roger
