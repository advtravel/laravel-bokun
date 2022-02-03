<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

use Adventures\LaravelBokun\ArrayOf;

class Booking extends DTO
{
    use HasTimeStamps;

    protected static function getTimeStampColumnNames(): array
    {
        return [
            'lastModifiedDate',
            'createdDate',
        ];
    }

    public function __construct(
        public Vendor $seller,
        public string $confirmationCode,
        public int $lastModifiedDate,
        public float $totalPaid,
        public string $bookingRole,
        public string $externalReference,
        public int $createdDate,
        public float $totalUnpaid,
        #[ArrayOf(ExperienceBooking::class)]
        public array $experienceBookings,
        public string $currency,
        public int $id,
        public string $status,
        public ?Customer $customer = null,
    ) {
    }
}
