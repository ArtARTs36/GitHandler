<?php

namespace ArtARTs36\GitHandler\Command\Groups\Contracts;

interface GitCommitCommand
{
    public function commit(string $message, bool $amend = false): bool;

    /**
     * equals: git add (untracked files) && git commit -m $message
     */
    public function autoCommit(string $message, bool $amend = false): bool;
}
