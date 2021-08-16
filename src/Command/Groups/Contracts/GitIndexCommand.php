<?php

namespace ArtARTs36\GitHandler\Command\Groups\Contracts;

/**
 * Git Index: (git add, git rm, ...)
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
}
