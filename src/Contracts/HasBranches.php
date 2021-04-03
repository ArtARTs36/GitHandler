<?php

namespace ArtARTs36\GitHandler\Contracts;

use ArtARTs36\GitHandler\Exceptions\BranchNotFound;

interface HasBranches
{
    /**
     * equals: git checkout <branch>
     * @throws BranchNotFound
     */
    public function checkout(string $branch, bool $merge = false): bool;

    public function deleteBranch(string $branch): bool;
}
