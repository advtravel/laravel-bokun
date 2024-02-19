<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

use Adventures\LaravelBokun\ArrayOf;
use Adventures\LaravelBokun\GraphQL\Types\BookingPaymentStatus;
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
        public int $id,
        public ?Vendor $seller = null,
        public ?string $confirmationCode = null,
        public ?int $lastModifiedDate = null,
        public ?float $totalPaid = null,
        public ?BookingRole $bookingRole = null,
        public ?string $externalReference = null,
        public ?int $createdDate = null,
        public ?float $totalUnpaid = null,
        #[ArrayOf(ExperienceBooking::class)]
        public ?array $experienceBookings = null,
        public ?string $currency = null,
        public ?BookingStatus $status = null,
        public ?Customer $customer = null,
        public ?CustomerInvoice $customerInvoice = null,
        public ?BookingPaymentStatus $paymentStatus = null,
    ) {
    }
}
