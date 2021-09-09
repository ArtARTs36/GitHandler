<?php

namespace ArtARTs36\GitHandler\Attributes;

use ArtARTs36\GitHandler\Contracts\Config\ConfigAttribute;

#[\Attribute]
class ConfigSectionName implements ConfigAttribute
{
    public function __toString(): string
    {
        return static::class;
    }
}
