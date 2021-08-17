<?php

namespace ArtARTs36\GitHandler\Command\Commands\Contracts;

use ArtARTs36\GitHandler\Exceptions\AlreadySwitched;
use ArtARTs36\GitHandler\Exceptions\BranchNotFound;
use ArtARTs36\GitHandler\Exceptions\ReferenceInvalid;
use ArtARTs36\Str\Str;

/**
 * Git Branches
 */
interface GitBranchCommand
{
    /**
     * Checkout to branch
     * @git-command git checkout {$branch}
     * @throws BranchNotFound
     */
    public function checkout(string $branch, bool $merge = false): bool;

    /**
     * Delete Branch
     * @git-command git branch -d {$branch}
     * @throws BranchNotFound
     */
    public function delete(string $branch): bool;

    /**
     * Create new Branch
     * @git-command git branch {$branch}
     */
    public function newBranch(string $branch): bool;

    /**
     * Get all Branches
     * @git-command git branch -a
     * @return array<string>
     */
    public function getBranches(): array;

    /**
     * Switch to Branch
     * @git-command git switch {$branch}
     * @throws ReferenceInvalid
     * @throws AlreadySwitched
     */
    public function switchBranch(string $branch): bool;

    /**
     * Get current Branch
     * @git-command git branch --show-current
     */
    public function getCurrentBranch(): Str;
}
