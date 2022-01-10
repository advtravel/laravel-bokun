<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

class CheckoutCompleteInput extends DTO
{
    public function __construct(
        public BookingDataInput $bookingData,
        public CheckoutPaymentInput $payment,
        public bool $sendNotificationToCustomer = false,
        public ?string $externalReference = null,
    ) {
    }
}
