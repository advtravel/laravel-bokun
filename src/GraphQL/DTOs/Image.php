<?php

namespace Adventures\LaravelBokun\GraphQL\DTOs;

class Image extends DTO
{
    public function __construct(
        public int $id,
        public ?string $alternateText = null,
        public ?string $caption = null,
        public ?int $height = null,
        public ?string $originalUrl = null,
        public ?string $previewUrl = null,
        public ?string $thumbnailUrl = null,
        public ?int $width = null,
    ) {
    }
}
