<?php

namespace ArtARTs36\GitHandler\Command\Groups\Contracts;

/**
 * Git Commits
 */
interface GitCommitCommand
{
    /**
     * Execute commit
     * @git-command git commit -m="{$message}"
     * @git-command git commit -m="{$message}" --amend
     */
    public function commit(string $message, bool $amend = false): bool;

    /**
     * equals: git add (untracked files) && git commit -m $message
     */
    public function autoCommit(string $message, bool $amend = false): bool;
}
