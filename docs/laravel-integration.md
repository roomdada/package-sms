# Intégration Laravel - Letexto SMS Package

## Installation

```bash
composer require room/letexto-sms-package
```

## Configuration

### 1. Ajouter la configuration dans `config/services.php`

```php
'letexto' => [
    'token' => env('LETEXTO_TOKEN'),
    'base_url' => env('LETEXTO_BASE_URL', 'https://apis.letexto.com/v1'),
],
```

### 2. Ajouter les variables dans `.env`

```env
LETEXTO_TOKEN=votre_token_ici
LETEXTO_BASE_URL=https://apis.letexto.com/v1
```

## Utilisation

### Dans un Controller

```php
<?php

namespace App\Http\Controllers;

use Room\Sms\SmsClient;

class SmsController extends Controller
{
    public function sendSms()
    {
        $client = new SmsClient([
            'token' => config('services.letexto.token'),
            'base_url' => config('services.letexto.base_url'),
        ]);

        try {
            $response = $client->send([
                'to' => '2250100000000',
                'content' => 'Votre code de vérification est: 123456',
                'from' => 'MonApp'
            ]);

            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
```

### Dans un Service Provider (recommandé)

```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Room\Sms\SmsClient;

class SmsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(SmsClient::class, function ($app) {
            return new SmsClient([
                'token' => config('services.letexto.token'),
                'base_url' => config('services.letexto.base_url'),
            ]);
        });
    }
}
```

### Utilisation avec Injection de Dépendance

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
            'from' => 'MonApp'
        ]);

        return response()->json($response);
    }
}
```

### Dans une Job Queue

```php
<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Room\Sms\SmsClient;

class SendSmsJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private string $to,
        private string $content,
        private string $from = 'MonApp'
    ) {}

    public function handle(SmsClient $smsClient)
    {
        $smsClient->send([
            'to' => $this->to,
            'content' => $this->content,
            'from' => $this->from,
        ]);
    }
}
```

## Exemples d'utilisation

### Envoi en masse

```php
$client = new SmsClient([
    'token' => config('services.letexto.token'),
]);

$response = $client->sendBulk([
    'to' => ['2250100000000', '2250200000000'],
    'content' => 'Message en masse',
    'from' => 'MonApp'
]);
```

### Vérification du statut

```php
$status = $client->getStatus('message-id-here');
```

## Gestion des erreurs

```php
try {
    $response = $client->send([
        'to' => '2250100000000',
        'content' => 'Test message',
        'from' => 'MonApp'
    ]);
} catch (\Room\Sms\Exceptions\ValidationException $e) {
    // Erreur de validation
    Log::error('SMS Validation Error: ' . $e->getMessage());
} catch (\Room\Sms\Exceptions\SmsException $e) {
    // Erreur API
    Log::error('SMS API Error: ' . $e->getMessage());
}
```
