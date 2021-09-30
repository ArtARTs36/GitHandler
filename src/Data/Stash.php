<?php

namespace ArtARTs36\GitHandler\Data;

use ArtARTs36\GitHandler\Contracts\Common\Arrayable;
use ArtARTs36\GitHandler\Support\ToArray;

class Stash implements Arrayable
{
    use ToArray;

    public $id;

    public $branch;

    public $name;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(int $id, string $branch, string $name)
    {
        $this->id = $id;
        $this->branch = $branch;
        $this->name = $name;
    }
}
