<?php

namespace Adventures\LaravelBokun\GraphQL\Types;

enum TicketCategory: string
{
    case Adult = 'ADULT';
    case Child = 'CHILD';
    case Teenager = 'TEENAGER';
    case Infant = 'INFANT';
    case Senior = 'SENIOR';
    case Student = 'STUDENT';
    case Military = 'MILITARY';
    case Group = 'GROUP';
    case Other = 'OTHER';
}
