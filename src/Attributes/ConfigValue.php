<?php

namespace ArtARTs36\GitHandler\Attributes;

use ArtARTs36\GitHandler\Contracts\Config\ConfigAttribute;

#[\Attribute]
class ConfigValue implements ConfigAttribute
{
    public function __toString(): string
    {
        return static::class;
    }
}
