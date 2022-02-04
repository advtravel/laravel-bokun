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
        /** @var array $response */

        if (isset($response['errors'])) {
            // Iterate through the errors and see whether there's one that we can skip
            $abort = false;
            foreach ($response['errors'] as $error) {
                if (
                    array_key_exists('extensions', $error) &&
                    array_key_exists('classification', $error['extensions']) &&
                    ($error['extensions']['classification'] === 'DataFetchingException')
                ) {
                    continue;
                }
                $abort = true;
            }

            if ($abort) {
                throw new RuntimeException("Bókun error message: " . ($response['errors'][0]['message'] ?? json_encode($response['errors'])));
            }
        }
        if (! isset($response['data'])) {
            throw new RuntimeException("No data in Bókun response");
        }

        return $response['data'];
    }

    private function bokunBaseURL(string $domain): string
    {
        return 'https://' . sprintf($this->getAppConfig()->base_url, $domain);
    }
}
