<?php

namespace Adventures\LaravelBokun\GraphQL\Queries;

use Adventures\LaravelBokun\GraphQL\DTOs\ScheduleFilterInput;
use Adventures\LaravelBokun\GraphQL\PagedQuery;

class GetExperienceScheduleQuery extends PagedQuery
{
    public function getName(): string
    {
        return 'experienceSchedule';
    }

    public function getValidInputs(): array
    {
        return [
            'filter' => ScheduleFilterInput::class,
        ] + parent::pagedValidInputs();
    }
}
