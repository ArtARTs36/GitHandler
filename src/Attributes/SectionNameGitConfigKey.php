<?php

namespace ArtARTs36\GitHandler\Attributes;

#[\Attribute]
class SectionNameGitConfigKey
{
    public function __toString()
    {
        return static::class;
    }
}
