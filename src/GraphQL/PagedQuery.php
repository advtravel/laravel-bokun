<?php

namespace Adventures\LaravelBokun\GraphQL;

abstract class PagedQuery extends Query
{
    protected function pagedValidInputs(): array
    {
        return [
            'last' => 'integer',
            'first' => 'integer',
            'before' => 'string',
            'after' => 'string',
        ];
    }

    protected function oneWayPagedValidInputs(): array
    {
        return [
            'after' => 'string',
            'first' => 'integer',
        ];
    }

    public function __construct(
        string $fields
    ) {
        $fields = 'pageInfo { hasNextPage, endCursor }, edges { node { ' . $fields . ' } } ';
        parent::__construct($fields);
    }
}
