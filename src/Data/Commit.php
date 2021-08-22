<?php

namespace ArtARTs36\GitHandler\Data;

class Commit
{
    public $hash;

    public function __construct(string $hash)
    {
        $this->hash = $hash;
    }

    public function getAbbreviatedHash(): string
    {
        return mb_substr($this->hash, 0, 6);
    }

    public function __toString(): string
    {
        return $this->hash;
    }
}
