<?php

namespace ArtARTs36\GitHandler\Command\Groups\Contracts;

interface GitFetchCommand
{
    /**
     * equals: git fetch
     */
    public function fetch(): void;

    public function fetchAll(): void;
}
