<?php

namespace ArtARTs36\GitHandler\Data;

use ArtARTs36\GitHandler\Support\ToArray;
use ArtARTs36\Str\Str;

class GitAttributes
{
    use ToArray;

    public $pattern;

    public $attributes;

    /**
     * @param array<string|Str> $attributes
     * @codeCoverageIgnore
     */
    public function __construct(string $pattern, array $attributes)
    {
        $this->pattern = $pattern;
        $this->attributes = $attributes;
    }

    public function has(string $attribute): bool
    {
        return in_array($attribute, $this->attributes);
    }
}
