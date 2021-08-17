<?php

namespace ArtARTs36\GitHandler\Command\Commands\Contracts;

use ArtARTs36\GitHandler\Enum\ResetMode;

/**
 * Git Index: (git add, git reset, git rm, ...)
 */
interface GitIndexCommand
{
    /**
     * @git-command git add $file
     * @git-command git add $file $file $file
     * @param string|array<string> $file - file name to git added
     */
    public function add($file, bool $force = false): bool;

    /**
     * @git-command git rm $file
     * @git-command git rm $file $file $file
     * @param string|array<string> $files
     */
    public function remove($files, bool $force = false): bool;

    /**
     * Git Reset
     * @git-command git reset --$mode $subject
     */
    public function reset(ResetMode $mode, string $subject): void;

    /**
     * Git Reset Head
     * @git-command git reset --$mode HEAD~
     */
    public function resetHead(ResetMode $mode): void;
}
