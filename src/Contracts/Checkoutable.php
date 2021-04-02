<?php

namespace ArtARTs36\GitHandler\Contracts;

use ArtARTs36\GitHandler\Exceptions\BranchNotFound;

interface Checkoutable
{
    /**
     * equals: git checkout <branch>
     * @throws BranchNotFound
     */
    public function checkout(string $branch, bool $merge = false): bool;
}
