# Letexto SMS Package

Package PHP pour l'envoi de SMS via l'API Letexto.

**Développé par :** DA Sie Roger (dsieroger@gmail.com)

## Installation

```bash
composer require room/letexto-sms-package
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

## Fonctionnalités

- ✅ Envoi de SMS simple
- ✅ Envoi en masse
- ✅ Gestion des erreurs
- ✅ Validation des numéros de téléphone
- ✅ Support des caractères spéciaux
- ✅ Rapports de livraison
- ✅ Compatible avec l'API Letexto

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
