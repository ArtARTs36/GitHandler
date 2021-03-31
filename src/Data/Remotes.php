<?php

namespace ArtARTs36\GitHandler\Data;

use ArtARTs36\GitHandler\Support\ToArray;

class Remotes
{
    use ToArray;

    public $fetch;

    public $push;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(string $fetch, string $push)
    {
        $this->fetch = $fetch;
        $this->push = $push;
    }

    public static function createEmpty(): self
    {
        return new static('', '');
    }
}
