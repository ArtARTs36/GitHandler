<?php

namespace ArtARTs36\GitHandler\Attributes;

#[\Attribute]
class ConfigKey
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
