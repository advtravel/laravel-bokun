<?php

namespace Adventures\LaravelBokun\Legacy;

use Carbon\Carbon;
use GuzzleHttp\Exception\ClientException;

class Availabilities
{
    public function __construct(
        private RestApi $api,
        private bool $ignore404activities = true,
    ) {
    }

    public function getForDateRange(
        Carbon $from,
        Carbon $to,
        int|array $experience_ids
    ): array {
        if (! is_array($experience_ids)) {
            $experience_ids = [$experience_ids];
        }

        $query = http_build_query([
            'includeSoldOut' => 'true',
            'start' => $from->toDateString(),
            'end' => $to->toDateString(),
        ]);

        $results = [];
        foreach ($experience_ids as $id) {
            try {
                $results[$id] = $this->api->makeRequest(
                    'GET',
                    "/activity.json/{$id}/availabilities?" . $query
                );
            } catch (ClientException $e) {
                if (! $this->ignore404activities) {
                    throw $e;
                }

                if ($e->getResponse()->getStatusCode() !== 404) {
                    throw $e;
                }
            }
        }

        return $results;
    }
}
