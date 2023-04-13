<?php

namespace Adventures\LaravelBokun\GraphQL\Types;

enum LocationOrigin: string
{
    case FreetextLocation = 'FREETEXT_LOCATION';
    case GooglePlaces = 'GOOGLE_PLACES';
    case TripadvisorApi = 'TRIPADVISOR_API';
}
