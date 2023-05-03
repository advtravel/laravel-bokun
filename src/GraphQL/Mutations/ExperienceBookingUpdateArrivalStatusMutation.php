<?php

namespace Adventures\LaravelBokun\GraphQL\Mutations;

use Adventures\LaravelBokun\GraphQL\DTOs\ExperienceBookingUpdateArrivalStatusInput;
use Adventures\LaravelBokun\GraphQL\Query;

class ExperienceBookingUpdateArrivalStatusMutation extends Query
{

    public function getName(): string {
        return 'experienceBookingUpdateArrivalStatus';
    }

    public function getValidInputs(): array {
        return [
            'experienceBookingUpdateArrivalStatusInput' => ExperienceBookingUpdateArrivalStatusInput::class
        ];
    }
    
}
