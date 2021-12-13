<?php

namespace ArtARTs36\GitHandler\Contracts\Commands;

use ArtARTs36\GitHandler\Data\Author;

/**
 * Git Commits
 */
interface GitCommitCommand
{
    /**
     * Execute commit
     * @git-command git commit -m="{$message}"
     * @git-command git commit -m="{$message}" --amend
     * @git-command git commit -m="{$message}" --author="$author"
     */
    public function commit(string $message, bool $amend = false, ?Author $author = null): bool;

    /**
     * @git-command git add (untracked files) && git commit -m $message
     */
    public function autoCommit(string $message, bool $amend = false): bool;
}
