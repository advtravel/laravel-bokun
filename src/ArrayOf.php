<?php

namespace Adventures\LaravelBokun;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class ArrayOf
{
    public function __construct(
        private string $className,
        private ?array $excludeKeys = []
    ) {
    }

    public function getClassName(): string
    {
        return $this->className;
    }

    public function getExcludeKeys(): array
    {
        return $this->excludeKeys ?? [];
    }
}
