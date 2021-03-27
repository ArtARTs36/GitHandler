<?php

namespace ArtARTs36\GitHandler\Contracts;

use ArtARTs36\GitHandler\Data\Remotes;

interface HasRemotes
{
    public function addRemote(string $shortName, string $url): bool;

    /**
     * equals: git remote show origin
     */
    public function showRemote(): Remotes;
}
