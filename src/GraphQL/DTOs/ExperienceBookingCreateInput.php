<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

class ExperienceBookingCreateInput extends DTO
{
    /**
     * @param array<PassengerBookingCreateInput> $passengers
     */
    public function __construct(
        public int $experienceId,
        public int $rateId,
        public int $startTimeId,
        public int $dateTimestamp,
        public array $passengers,
        public ?int $pickupPlaceId = null,
        public ?int $dropoffPlaceId = null,
    ) {
    }

    protected function encodeSpecialFields(string $name, mixed $value): array
    {
        if ($name === 'dateTimestamp') {
            /** @var int $value */
            return ['date' => date('Y-m-d', $value)];
        }

        $fields = parent::encodeSpecialFields($name, $value);

        if ($name === 'pickupPlaceId') {
            $fields['pickup'] = true;
        }
        if ($name === 'dropoffPlaceId') {
            $fields['dropoff'] = true;
        }

        return $fields;
    }
}
