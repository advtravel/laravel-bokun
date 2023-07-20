<?php

namespace Adventures\LaravelBokun\GraphQL;

use Adventures\LaravelBokun\AppStore\BokunAppConfig;
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
            throw new RuntimeException(
                'Bókun error message: ' .
                ($response['errors'][0]['message'] ?? json_encode($response['errors'])) .
                ', Query: ' . $query
            );
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

    /**
     * Like http_build_query but only accepts a flat input array as parameter
     * And nothing is encoded. This is how Bókun builds the query for HMAC validation
     */
    private function buildQuery(array $query): string
    {
        if (! count($query)) {
            return '';
        }
        $return = '';
        foreach ($query as $key => $value) {
            if ($return) {
                $return .= '&';
            }
            $return .= $key . '=' . $value;
        }

        return $return;
    }

    private function hmacIsValid(array $query, string $key = 'hmac'): bool
    {
        if (! array_key_exists($key, $query)) {
            return false;
        }

        $hmac = $query[$key];
        unset($query[$key]);
        ksort($query);

        $query_to_verify = $this->buildQuery($query);

        $hash = hash_hmac('sha256', $query_to_verify, $this->getAppConfig()->app_secret, false);

        return $hash === $hmac;
    }

    private function webhookHmacIsValid(array $headers, string $prefix = 'x-bokun-', string $hmacHeader = 'hmac'): bool
    {
        if (! array_key_exists($prefix . $hmacHeader, $headers)) {
            return false;
        }

        $headers = array_filter(
            $headers,
            fn (string $key) => str_starts_with($key, $prefix),
            ARRAY_FILTER_USE_KEY
        );

        $headers = array_map(fn(array $values) => reset($values), $headers);

        return $this->hmacIsValid($headers, $prefix . $hmacHeader);
    }
}
