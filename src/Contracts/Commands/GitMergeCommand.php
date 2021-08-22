<?php

namespace ArtARTs36\GitHandler\Contracts\Commands;

use ArtARTs36\GitHandler\Exceptions\CannotMergeAbort;
use ArtARTs36\GitHandler\Exceptions\CannotMergeException;

/**
 * Git Merge
 */
interface GitMergeCommand
{
    /**
     * Merge with branch
     * @git-command git merge $branch
     * @git-command git merge $branch -m=$message
     * @throws CannotMergeException
     */
    public function merge(string $branch, ?string $message = null): void;

    /**
     * Squash Merge with branch
     * @git-command git merge $branch --squash
     * @git-command git merge $branch -m=$message --squash
     * @throws CannotMergeException
     */
    public function mergeSquash(string $branch, ?string $message = null): void;

    /**
     * Abort merge
     * @git-command git merge --abort
     * @throws CannotMergeAbort
     */
    public function abort(): void;
}
