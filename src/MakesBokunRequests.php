<?php

namespace Adventures\LaravelBokun;

use GuzzleHttp\Client;
use RuntimeException;

trait MakesBokunRequests
{
    abstract protected function getAppConfig(): BokunAppConfig;

    private function makeRequest(string $query, string $access_token): array
    {
        $bokunUrl = $this->bokunBaseURL('extranet') . '/api/graphql';

        $client = new Client();
        $response = $client->post($bokunUrl, [
            'json' => [
                'query' => $query,
                'variables' => null,
            ],
            'headers' => [
                'X-Bokun-App-Access-Token' => $access_token,
            ],
        ])->getBody();

        $response = json_decode($response, associative: true, flags: JSON_THROW_ON_ERROR);

        if (! isset($response['data'])) {
            throw new RuntimeException("No data in Bókun response");
        }

        return $response['data'];
    }

    private function bokunBaseURL(string $domain): string
    {
        return 'https://' . sprintf($this->getAppConfig()->domain, $domain);
    }

    private function parseB64ID(string $base64id): array
    {
        $text = base64_decode($base64id);
        [$key, $value] = explode(':', $text, 2);

        return [$key => $value];
    }
}
