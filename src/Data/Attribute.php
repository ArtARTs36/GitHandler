<?php

namespace ArtARTs36\GitHandler\Data;

class Attribute
{
    public $pattern;

    public $attrs;

    public function __construct(string $pattern, array $attrs)
    {
        $this->pattern = $pattern;
        $this->attrs = $attrs;
    }
}
