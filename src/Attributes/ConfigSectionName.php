<?php

namespace ArtARTs36\GitHandler\Attributes;

#[\Attribute]
class ConfigSectionName
{
    public function __toString()
    {
        return static::class;
    }
}
