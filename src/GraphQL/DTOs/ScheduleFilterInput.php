<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

class ScheduleFilterInput extends DTO
{
    use HasTimeStamps;
    protected static function getTimeStampColumnNames(): array
    {
        return [
            'dateTimeFrom',
            'dateTimeTo',
        ];
    }
    
    /**
     * @param array<int> $experienceIds
     */
    public function __construct(
        public int $dateTimeFrom,
        public int $dateTimeTo,
        public array $experienceIds,
        public bool $bookedOnly = false
    ) {
    }
}
