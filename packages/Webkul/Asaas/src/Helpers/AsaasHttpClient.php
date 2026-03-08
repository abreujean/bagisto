<?php

namespace Webkul\Asaas\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class AsaasHttpClient
{
    protected $client;

    protected $apiKey;

    protected $environment;

    public function __construct()
    {
        $apiKey = core()->getConfigData('sales.payment_methods.asaas.api_key');
        $environment = core()->getConfigData('sales.payment_methods.asaas.environment');

        $this->apiKey = $apiKey;
        $this->environment = $environment ?: 'sandbox';

        $this->client = new Client([
            'base_uri' => $this->getApiUrl(),
            'timeout' => 30,
            'headers' => [
                'access_token' => $this->apiKey,
                'Content-Type' => 'application/json',
                'accept' => 'application/json',
            ],
        ]);
    }

    protected function getApiUrl(): string
    {
        return $this->environment === 'production'
            ? 'https://api.asaas.com/v3/'
            : 'https://sandbox.asaas.com/v3/';
    }

    public function post(string $endpoint, array $data = []): array
    {
        try {
            $response = $this->client->post($endpoint, [
                'json' => $data,
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            $this->handleError($e);
        }
    }

    public function get(string $endpoint): array
    {
        try {
            $response = $this->client->get($endpoint);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            $this->handleError($e);
        }
    }

    public function put(string $endpoint, array $data = []): array
    {
        try {
            $response = $this->client->put($endpoint, [
                'json' => $data,
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            $this->handleError($e);
        }
    }

    public function delete(string $endpoint): array
    {
        try {
            $response = $this->client->delete($endpoint);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            $this->handleError($e);
        }
    }

    protected function handleError(RequestException $e)
    {
        if ($e->hasResponse()) {
            $response = $e->getResponse();
            $body = json_decode($response->getBody()->getContents(), true);

            $errors = $body['errors'] ?? [];
            $errorMessage = implode(', ', array_column($errors, 'description'));

            throw new \Exception($errorMessage ?: 'Erro na comunicação com Asaas', $response->getStatusCode());
        }

        throw new \Exception('Erro de conexão com Asaas: '.$e->getMessage());
    }
}
