<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

class GeoPoint extends DTO
{
    public function __construct(
        public float $latitude,
        public float $longitude,
    ) {
    }
}
