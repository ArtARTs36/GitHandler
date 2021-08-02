<?php

namespace ArtARTs36\GitHandler\Config\Subjects;

class Branch
{
    public $name;

    public $remote;

    public $merge;

    public function __construct(string $name, string $remote, string $merge)
    {
        $this->name = $name;
        $this->remote = $remote;
        $this->merge = $merge;
    }
}
