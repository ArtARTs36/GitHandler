<?php

namespace ArtARTs36\GitHandler\Contracts\Commands;

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
    public function create(string $branch): void;

    /**
     * Get all Branches
     * @git-command git branch -a
     * @return array<string>
     */
    public function getAll(): array;

    /**
     * Switch to Branch
     * @git-command git switch {$branch}
     * @throws ReferenceInvalid
     * @throws AlreadySwitched
     */
    public function switch(string $branch): bool;

    /**
     * Get current Branch
     * @git-command git branch --show-current
     */
    public function current(): Str;
}
