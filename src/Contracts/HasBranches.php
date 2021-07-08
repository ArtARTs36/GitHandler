<?php

namespace ArtARTs36\GitHandler\Contracts;

use ArtARTs36\GitHandler\Exceptions\BranchNotFound;
use ArtARTs36\Str\Str;

interface HasBranches
{
    /**
     * equals: git checkout <branch>
     * @throws BranchNotFound
     */
    public function checkout(string $branch, bool $merge = false): bool;

    public function deleteBranch(string $branch): bool;

    public function newBranch(string $branch): bool;

    /**
     * @return array<string>
     */
    public function getBranches(): array;

    /**
     * equals: git branch --show-current
     */
    public function getCurrentBranch(): Str;
}
