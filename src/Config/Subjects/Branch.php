<?php

namespace ArtARTs36\GitHandler\Config\Subjects;

use ArtARTs36\GitHandler\Support\ToArray;

class Branch
{
    use ToArray;

    public $name;

    public $remote;

    public $merge;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(string $name, string $remote, string $merge)
    {
        $this->name = $name;
        $this->remote = $remote;
        $this->merge = $merge;
    }
}
