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
    'to' => '212689131285',
    'content' => 'Votre code de vérification est: 123456',
    'from' => 'Daylivro'
]);
```

### Envoi d'un SMS avec expéditeur personnalisé

```php
$response = $client->send([
    'to' => '212689131285',
    'content' => 'Message de test',
    'from' => 'MonApp'
]);
```

### Envoi en masse

```php
$response = $client->sendBulk([
    'to' => ['212689131285', '212698765432'],
    'content' => 'Message en masse',
    'from' => 'Daylivro'
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
curl --location 'https://apis.letexto.com/v1/messages/send?from=Daylivro&to=212689131285&content=Bienvenue%20sur%20daylivro&token=aeca24110a548d582c1bbdd0ef8feddf'
```

## Tests

```bash
composer test
```

## Licence

MIT License - Développé par DA Sie Roger
