<?php

namespace ArtARTs36\GitHandler\Attributes;

use ArtARTs36\GitHandler\Contracts\Attribute\GitAttribute;

#[\Attribute]
class ConfigSectionName implements GitAttribute
{
    public function __toString()
    {
        return static::class;
    }
}
