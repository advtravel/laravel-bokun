<?php

namespace Adventures\LaravelBokun\Legacy;

use GuzzleHttp\Client;

class RestApi
{
    private Client $client;

    public function __construct(
        private string $access_key,
        private string $secret_key,
        string $base_uri = 'https://api.bokuntest.com/',
    )
    {
        $this->client = new Client([
            'base_uri' => $base_uri
        ]);
    }

    private function generateHeaders(
        string $method,
        string $path
    ): array {
        $date = gmdate('Y-m-d H:i:s');
        $signature_payload =
            $date
            . $this->access_key
            . strtoupper($method)
            . $path;
        $signature_binary = hash_hmac(
            'sha1',
            $signature_payload,
            $this->secret_key,
            true
        );
        $signature_base64 = base64_encode($signature_binary);

        return [
            'X-Bokun-Date' => $date,
            'X-Bokun-AccessKey' => $this->access_key,
            'X-Bokun-Signature' => $signature_base64
        ];
    }

    public function makeRequest(
        string $method,
        string $path,
        ?array $body = null
    ): array {
        $options = [
            'headers' => $this->generateHeaders($method, $path),
        ];

        if (!is_null($body)) {
            $headers['Content-Type'] = 'application/json';
            $options['body'] = json_encode($body);
        }

        $response = $this->client->request($method, $path, $options);

        $data = json_decode((string) $response->getBody(), true);

        return $data ;
    }
}
