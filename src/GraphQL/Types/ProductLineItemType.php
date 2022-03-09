<?php

namespace Adventures\LaravelBokun\GraphQL\Types;

enum ProductLineItemType: string
{
    case Passengers = 'PASSENGERS';
    case Rooms = 'ROOMS';
    case Vehicles = 'VEHICLES';
    case Extras = 'EXTRAS';
    case PickUp = 'PICK_UP';
    case DropOff = 'DROP_OFF';
    case ServiceFee = 'SERVICE_FEE';
    case CancellationFee = 'CANCELLATION_FEE';
    case Custom = 'CUSTOM';
    case GiftCard = 'GIFT_CARD';
}
