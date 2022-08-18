<?php

namespace Adventures\LaravelBokun\GraphQL;

use Adventures\LaravelBokun\AppStore\BokunAppConfig;
use Iterator;
use RuntimeException;

class Connection
{
    use MakesBokunRequests;

    public function __construct(
        public readonly BokunAppConfig $app_config,
        public readonly string $access_token,
    ) {
    }

    protected function getAppConfig(): BokunAppConfig
    {
        return $this->app_config;
    }

    protected function execute(Query $query, string $verb): array
    {
        $data = $this->makeRequest($verb . ' { ' . $query . ' }', $this->access_token);
        if (isset($data['error'])) {
            throw new RuntimeException("Bókun GraphQL error: " . json_encode($data['error'], JSON_PRETTY_PRINT));
        }
        $interestingData = $data[$query->getName()]
            ?? throw new RuntimeException("Didn't find expected data in $verb return");

        return $interestingData;
    }

    public function executeMutation(Query $mutation): array
    {
        return $this->execute($mutation, 'mutation');
    }

    public function executeQuery(Query $query): array
    {
        return $this->execute($query, 'query');
    }

    public function executePagedQuery(PagedQuery $query): Iterator
    {
        $hasNextPage = false;
        do {
            $result = $this->executeQuery($query);
            $hasNextPage = $result['pageInfo']['hasNextPage'];
            if ($hasNextPage) {
                $query->withArgument('after', $result['pageInfo']['endCursor']);
            }

            foreach ($result['edges'] as $edge) {
                yield $edge['node'];
            }
        } while ($hasNextPage);
    }
}
