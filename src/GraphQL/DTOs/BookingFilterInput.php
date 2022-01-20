<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

use Adventures\LaravelBokun\ArrayOf;

class BookingFilterInput extends DTO
{
    use HasTimeStamps;
    protected static function getTimeStampColumnNames(): array
    {
        return [
            'travelDateFrom',
            'travelDateTo',
            'createdDateFrom',
            'createdDateTo',
            'cancelDateFrom',
            'cancelDateTo',
        ];
    }

    public function __construct(
        public ?int $createdDateFrom = null,
        public ?int $createdDateTo = null,
        public ?int $cancelDateFrom = null,
        public ?int $cancelDateTo = null,
        public ?int $travelDateFrom = null,
        public ?int $travelDateTo = null,
        public ?int $supplierId = null,
        #[ArrayOf('string')]
        public ?array $status = null,
        public ?string $searchTerm = null,
        public ?int $sellerId = null,
        public ?string $confirmationCode = null,
        public ?int $bookingChannelId = null,
    ) {
    }
}
