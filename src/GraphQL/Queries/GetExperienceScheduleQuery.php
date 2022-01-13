<?php

namespace Adventures\LaravelBokun\GraphQL\Queries;

use Adventures\LaravelBokun\GraphQL\DTOs\ScheduleFilterInput;
use Adventures\LaravelBokun\GraphQL\Query;

class GetExperienceScheduleQuery extends Query
{
    public function getName(): string
    {
        return 'experienceSchedule';
    }

    public function getValidInputs(): array
    {
        return [
            'filter' => ScheduleFilterInput::class,
        ];
    }
}
