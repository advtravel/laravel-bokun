<?php

namespace Adventures\LaravelBokun\GraphQL\Queries;

use Adventures\LaravelBokun\GraphQL\DTOs\ExperienceFilterInput;
use Adventures\LaravelBokun\GraphQL\DTOs\ExperienceSortInput;
use Adventures\LaravelBokun\GraphQL\PagedQuery;

class ListExperiencesQuery extends PagedQuery
{
    public function getName(): string
    {
        return 'experiences';
    }

    public function getValidInputs(): array
    {
        return [
            'sort' => ExperienceSortInput::class,
            'filter' => ExperienceFilterInput::class,
        ] + parent::pagedValidInputs();
    }
}
