<?php

namespace ArtARTs36\GitHandler\Data;

class Remotes
{
    public $fetch;

    public $push;

    public function __construct(string $fetch, string $push)
    {
        $this->fetch = $fetch;
        $this->push = $push;
    }

    public static function createEmpty(): self
    {
        return new static('', '');
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
