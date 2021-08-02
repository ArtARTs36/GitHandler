<?php

namespace ArtARTs36\GitHandler\Config\Subjects;

class LinkBranch
{
    public $remote;

    public $merge;

    public function __construct(string $remote, string $merge)
    {
        $this->remote = $remote;
        $this->merge = $merge;
    }
}
