<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

use Adventures\LaravelBokun\ArrayOf;
use Adventures\LaravelBokun\GraphQL\Types\BookingRole;
use Adventures\LaravelBokun\GraphQL\Types\BookingStatus;

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
        public BookingRole $bookingRole,
        public string $externalReference,
        public int $createdDate,
        public float $totalUnpaid,
        #[ArrayOf(ExperienceBooking::class)]
        public array $experienceBookings,
        public string $currency,
        public int $id,
        public BookingStatus $status,
        public Customer $customer,
        public CustomerInvoice $customerInvoice,
    ) {
    }
}
