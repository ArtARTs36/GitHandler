<?php

namespace ArtARTs36\GitHandler\Command\Groups\Contracts;

interface GitCloneCommand
{
    /**
     * equals: git clone <url> -b <branch>
     */
    public function clone(string $url, ?string $branch = null, ?string $folder = null): bool;
}
