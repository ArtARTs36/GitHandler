<?php

namespace ArtARTs36\GitHandler\Contracts\Commands;

/**
 * Git Merge
 */
interface GitMergeCommand
{
    /**
     * Merge with branch
     * @git-command git merge $branch
     * @git-command git merge $branch -m=$message
     */
    public function merge(string $branch, ?string $message = null): void;

    /**
     * Squash Merge with branch
     * @git-command git merge $branch --squash
     * @git-command git merge $branch -m=$message --squash
     */
    public function mergeSquash(string $branch, ?string $message = null): void;

    /**
     * Abort merge
     * @git-command git merge --abort
     */
    public function abort(): void;
}
