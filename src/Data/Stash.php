<?php

namespace ArtARTs36\GitHandler\Data;

use ArtARTs36\GitHandler\Support\ToArray;

class Stash
{
    use ToArray;

    public $id;

    public $branch;

    public $name;

    public function __construct(int $id, string $branch, string $name)
    {
        $this->id = $id;
        $this->branch = $branch;
        $this->name = $name;
    }
}
