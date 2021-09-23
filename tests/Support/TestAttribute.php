<?php

namespace ArtARTs36\GitHandler\Tests\Support;

#[\Attribute]
class TestAttribute
{
    public $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }
}
