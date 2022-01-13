<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

class ScheduleFilterInput extends DTO
{
    public const DATETIME_FORMAT = 'Y-m-d\\TH:m:s';

    /**
     * @param string $dateTimeFrom yyyy-MM-ddTHH:mm:ss
     * @param string $dateTimeTo   yyyy-MM-ddTHH:mm:ss
     * @param array<int> $experienceIds
     */
    public function __construct(
        public string $dateTimeFrom,
        public string $dateTimeTo,
        public array $experienceIds,
        public bool $bookedOnly = false
    ) {
    }
}
