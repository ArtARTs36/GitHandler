<?php

namespace ArtARTs36\GitHandler\Data;

use ArtARTs36\Str\Str;

class GitAttributes
{
    public $pattern;

    public $attributes;

    /**
     * @param array<string|Str> $attributes
     */
    public function __construct(string $pattern, array $attributes)
    {
        $this->pattern = $pattern;
        $this->attributes = $attributes;
    }
}
