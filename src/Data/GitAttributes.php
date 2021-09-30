<?php

namespace ArtARTs36\GitHandler\Data;

use ArtARTs36\GitHandler\Contracts\Common\Arrayable;
use ArtARTs36\GitHandler\Support\ToArray;
use ArtARTs36\Str\Str;

class GitAttributes implements Arrayable
{
    use ToArray;

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

    public function has(string $attribute): bool
    {
        return in_array($attribute, $this->attributes);
    }
}
