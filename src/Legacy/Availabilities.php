<?php

namespace Adventures\LaravelBokun\Legacy;

use Carbon\Carbon;

class Availabilities
{
    public function __construct(
        private RestApi $api
    ) {
    }

    public function getForDateRange(
        Carbon $from,
        Carbon $to,
        int|array $experience_ids
    ): array {
        if (!is_array($experience_ids)) {
            $experience_ids = [$experience_ids];
        }

        $query = http_build_query([
            'includeSoldOut' => 'true',
            'start' => $from->toDateString(),
            'end' => $to->toDateString()
        ]);

        $results = [];
        foreach($experience_ids as $id) {
            $results[$id] = $this->api->makeRequest(
                'GET',
                "/activity.json/{$id}/availabilities?" . $query
            );
        }
        return $results;
    }

}
