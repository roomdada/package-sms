<?php

namespace Room\Sms;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Room\Sms\Exceptions\SmsException;
use Room\Sms\Exceptions\ValidationException;

class SmsClient
{
    private Client $httpClient;
    private array $config;

    public function __construct(array $config = [])
    {
        $this->config = array_merge([
            'token' => '',
            'base_url' => 'https://apis.letexto.com/v1',
            'timeout' => 30,
        ], $config);

        $this->httpClient = new Client([
            'base_uri' => $this->config['base_url'],
            'timeout' => $this->config['timeout'],
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);
    }

    /**
     * Envoyer un SMS simple
     */
    public function send(array $data): array
    {
        $this->validateSendData($data);

        $params = [
            'from' => $data['from'] ?? 'AROLITECH',
            'to' => $this->formatPhoneNumber($data['to']),
            'content' => $data['content'],
            'token' => $this->config['token']
        ];

        return $this->makeRequest('GET', '/v1/messages/send', [], $params);
    }

    /**
     * Envoyer des SMS en masse
     */
    public function sendBulk(array $data): array
    {
        $this->validateBulkData($data);

        $responses = [];
        foreach ($data['to'] as $phone) {
            $responses[] = $this->send([
                'to' => $phone,
                'content' => $data['content'],
                'from' => $data['from'] ?? 'AROLITECH'
            ]);
        }

        return $responses;
    }

    /**
     * Vérifier le statut d'un SMS
     */
    public function getStatus(string $messageId): array
    {
        $params = [
            'token' => $this->config['token']
        ];

        return $this->makeRequest('GET', "/v1/messages/status/{$messageId}", [], $params);
    }

    /**
     * Obtenir le solde du compte
     * Note: Cet endpoint peut ne pas être disponible dans l'API Letexto
     */
    /*
    public function getBalance(): array
    {
        $params = [
            'token' => $this->config['token']
        ];

        return $this->makeRequest('GET', '/v1/account/balance', [], $params);
    }
    */

    /**
     * Effectuer une requête HTTP
     */
    private function makeRequest(string $method, string $endpoint, array $data = [], array $params = []): array
    {
        try {
            $options = [];

            if ($method === 'GET' && !empty($params)) {
                $endpoint .= '?' . http_build_query($params);
            } elseif ($method === 'POST') {
                $options['json'] = $data;
            }

            $response = $this->httpClient->request($method, $endpoint, $options);
            $body = json_decode($response->getBody()->getContents(), true);

            return $body ?? [];
        } catch (GuzzleException $e) {
            throw new SmsException("Erreur de communication avec l'API Letexto: " . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Valider les données d'envoi
     */
    private function validateSendData(array $data): void
    {
        if (empty($data['to'])) {
            throw new ValidationException('Le numéro de téléphone est requis');
        }

        if (empty($data['content'])) {
            throw new ValidationException('Le contenu du message est requis');
        }

        if (strlen($data['content']) > 160) {
            throw new ValidationException('Le message ne peut pas dépasser 160 caractères');
        }
    }

    /**
     * Valider les données d'envoi en masse
     */
    private function validateBulkData(array $data): void
    {
        if (empty($data['to']) || !is_array($data['to'])) {
            throw new ValidationException('La liste des numéros de téléphone est requise');
        }

        if (count($data['to']) > 100) {
            throw new ValidationException('Maximum 100 numéros de téléphone autorisés par envoi en masse');
        }

        if (empty($data['content'])) {
            throw new ValidationException('Le contenu du message est requis');
        }

        if (strlen($data['content']) > 160) {
            throw new ValidationException('Le message ne peut pas dépasser 160 caractères');
        }
    }

    /**
     * Formater un numéro de téléphone
     */
    private function formatPhoneNumber(string $phone): string
    {
        // Supprimer tous les espaces et le + s'il est présent
        $phone = preg_replace('/[\s+]/', '', $phone);

        // Vérifier que c'est un numéro valide (code pays + numéro)
        if (preg_match('/^[1-9][0-9]{7,14}$/', $phone)) {
            return $phone;
        }

        throw new ValidationException('Le numéro doit être au format international sans +, ex: 22567476595');
    }
}
