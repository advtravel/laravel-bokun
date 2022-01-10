<?php

namespace Adventures\LaravelBokun\GraphQL;

use Adventures\LaravelBokun\BokunAppConfig;
use Adventures\LaravelBokun\GraphQL\Mutations\Mutation;
use Adventures\LaravelBokun\MakesBokunRequests;
use RuntimeException;

class Connection
{
    use MakesBokunRequests;

    public function __construct(
        private BokunAppConfig $app_config,
        private string $access_token,
    ) {
    }

    protected function getAppConfig(): BokunAppConfig
    {
        return $this->app_config;
    }

    public function executeMutation(Mutation $mutation): array
    {
        $data = $this->makeRequest('mutation { ' . $mutation . ' }', $this->access_token);
        if (isset($data['error'])) {
            throw new RuntimeException("Bókun GraphQL error: " . json_encode($data['error'], JSON_PRETTY_PRINT));
        }
        $interestingData = $data[$mutation->getName()]
            ?? throw new RuntimeException("Didn't find expected data in mutation return");

        return $interestingData;
    }
}
