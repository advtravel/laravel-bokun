<?php

namespace Adventures\LaravelBokun\GraphQL\Types;

enum LocationType: string
{
    case Accommodation = 'ACCOMMODATION';
    case Airport = 'AIRPORT';
    case Other = 'OTHER';
    case Port = 'PORT';
    case Station = 'STATION';
}
