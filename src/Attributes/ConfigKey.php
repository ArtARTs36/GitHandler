<?php

namespace ArtARTs36\GitHandler\Attributes;

use ArtARTs36\GitHandler\Contracts\Config\ConfigAttribute;

#[\Attribute]
class ConfigKey implements ConfigAttribute
{
    public $key;

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function __toString(): string
    {
        return $this->key;
    }
}
