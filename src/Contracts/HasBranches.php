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

    public function newBranch(string $branch): bool;

    /**
     * @return array<string>
     */
    public function getBranches(): array;

    public function switchBranch(string $branch): void;
}
