<?php

namespace ArtARTs36\GitHandler\Data;

class Commit
{
    public $hash;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(string $hash)
    {
        $this->hash = $hash;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getAbbreviatedHash(): string
    {
        return mb_substr($this->hash, 0, 6);
    }
}
