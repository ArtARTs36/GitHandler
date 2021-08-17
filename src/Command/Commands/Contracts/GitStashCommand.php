<?php

namespace ArtARTs36\GitHandler\Command\Commands\Contracts;

use ArtARTs36\GitHandler\Data\Stash;

/**
 * Git Stash
 */
interface GitStashCommand
{
    /**
     * Git stash changes
     * @git-command git stash
     * @git-command git stash save $message
     */
    public function stash(?string $message = null): bool;

    /**
     * Git stash pop
     * @git-command git stash pop
     */
    public function pop(): bool;

    /**
     * Get all git stashes
     * @git-command git stash --list
     * @return array<Stash>
     */
    public function getStashList(): array;

    /**
     * Git apply stash
     * @git-command git apply stash stash@{$id}
     */
    public function applyStash(int $id): bool;
}
