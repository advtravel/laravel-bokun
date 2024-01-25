<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

use Adventures\LaravelBokun\ArrayOf;
use Adventures\LaravelBokun\GraphQL\Types\BookingStatus;
use Carbon\Carbon;

class ExperienceBooking extends DTO
{
    use HasTimeStamps;

    protected static function getTimeStampColumnNames(): array
    {
        return [
            'zonedStartDateAndTime',
            'startDateAndTime',
            'pickupDateAndTime',
        ];
    }

    public function __construct(
        public int $id,
        public ?int $zonedStartDateAndTime = null,
        public ?int $startDateAndTime = null,
        public ?Experience $experience = null,
        #[ArrayOf(PassengerBooking::class)]
        public ?array $passengers = null,
        #[ArrayOf(ExperienceBooking::class, ['childComboBookings'])]
        public ?array $childComboBookings = null,
        public ?int $totalPassengerCount = null,
        public ?int $totalSeatsOccupied = null,
        public ?string $reference = null,
        public ?ExperienceStartTime $startTime = null,
        public ?BookingStatus $bookingStatus = null,
        public ?string $customPickupPlace = null,
        public ?PickupPlace $dropoffPlace = null,
        public ?bool $pickup = null,
        public ?int $pickupDateAndTime = null,
        public ?PickupPlace $pickupPlace = null,
        #[ArrayOf(ExperienceQuestionAnswer::class)]
        public ?array $pickupQuestions = null,
        public ?string $bookedTitle = null,
        public ?string $customizedStartTime = null,
    ) {
    }

    public function startCarbon(): ?Carbon
    {
        if ($this->zonedStartDateAndTime === null && $this->startDateAndTime === null) {
            return null;
        }

        $carbon = Carbon::createFromTimestampUTC($this->zonedStartDateAndTime ?? $this->startDateAndTime);

        if ($this->experience?->timeZone !== null) {
            $carbon->setTimezone($this->experience->timeZone);
        }

        return $carbon;
    }
}
