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

        if ($name === 'pickupPlaceId' && $value !== null) {
            $fields['pickup'] = true;
        }
        if ($name === 'dropoffPlaceId' && $value !== null) {
            $fields['dropoff'] = true;
        }

        return $fields;
    }

    protected static function decodeSpecialFields(string $name, mixed $value): array
    {
        if (($name === 'pickup') || ($name === 'dropoff')) {
            return [];
        }

        if ($name === 'date') {
            /** @var string $value */
            return ['dateTimestamp' => strtotime($value)];
        }

        return parent::decodeSpecialFields($name, $value);
    }
}
