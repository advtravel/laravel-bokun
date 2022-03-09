<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

use Adventures\LaravelBokun\ArrayOf;

class ExperienceQuestionAnswer extends DTO
{
    public function __construct(
        public int $id,
        public bool $required,
        public string $label,
        public ?string $answer = null,
        #[ArrayOf('string')]
        public ?array $answers = null,
        public ?string $defaultValue = null,
        public ?string $questionCode = null,
    ) {
    }
}
