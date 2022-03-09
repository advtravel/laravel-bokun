<?php

namespace Adventures\LaravelBokun\GraphQL\Types;

enum ExperienceSortField: string
{
    case Name = 'NAME';
    case ProductCode = 'PRODUCT_CODE';
    case CreatedDate = 'CREATED_DATE';
    case LastModifiedDate = 'LAST_MODIFIED_DATE';
}
