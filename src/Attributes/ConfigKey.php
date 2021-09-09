<?php

namespace ArtARTs36\GitHandler\Attributes;

use ArtARTs36\GitHandler\Contracts\Attribute\GitAttribute;

#[\Attribute]
class ConfigKey implements GitAttribute
{
    public $key;

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function __toString()
    {
        return $this->key;
    }
}
