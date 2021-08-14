<?php

namespace ArtARTs36\GitHandler\Command\Groups\Contracts;

use ArtARTs36\GitHandler\Exceptions\BranchNotFound;
use ArtARTs36\Str\Str;

interface GitBranchCommand
{
    /**
     * equals: git checkout <branch>
     * @throws BranchNotFound
     */
    public function checkout(string $branch, bool $merge = false): bool;

    /**
     * equals: git branch -d {branchName}
     * @throws BranchNotFound
     */
    public function deleteBranch(string $branch): bool;

    public function newBranch(string $branch): bool;

    /**
     * @return array<string>
     */
    public function getBranches(): array;

    public function switchBranch(string $branch): bool;

    /**
     * equals: git branch --show-current
     */
    public function getCurrentBranch(): Str;
}