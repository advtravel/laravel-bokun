<?php

namespace Adventures\LaravelBokun;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class ArrayOf
{
    public function __construct(
        private string $className
    ) {
    }

    public function getClassName(): string
    {
        return $this->className;
    }
}
