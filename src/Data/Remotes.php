<?php

namespace ArtARTs36\GitHandler\Data;

use ArtARTs36\GitHandler\Support\ToArray;
use ArtARTs36\Str\Str;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
class Remotes
{
    use ToArray;

    public $fetch;

    public $push;

    public function __construct(Str $fetch, Str $push)
    {
        $this->fetch = $fetch;
        $this->push = $push;
    }

    public static function createEmpty(): self
    {
        return new static(new Str(''), new Str(''));
    }

    public function isEmpty(): bool
    {
        return $this->fetch->isEmpty() && $this->push->isEmpty();
    }
}
