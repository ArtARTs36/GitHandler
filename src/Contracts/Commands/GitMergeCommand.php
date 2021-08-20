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
     */
    public function mergeWithBranch(string $branch): void;

    /**
     * Abort merge
     * @git-command git merge --abort
     */
    public function abort(): void;
}
