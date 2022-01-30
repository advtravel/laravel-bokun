<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

use Adventures\LaravelBokun\ArrayOf;

class ExtraBooking extends DTO
{
    public function __construct(
        public int $id,
        public int $quantity,
        public ?Extra $extra = null,
        #[ArrayOf(ExperienceQuestionAnswer::class)]
        public ?array $questions = null,
    ) {
    }
}
