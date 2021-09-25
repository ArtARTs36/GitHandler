<?php

namespace ArtARTs36\GitHandler\Contracts\Commands;

use ArtARTs36\GitHandler\Enum\ResetMode;
use ArtARTs36\GitHandler\Exceptions\BadRevision;
use ArtARTs36\GitHandler\Exceptions\BranchNotFound;
use ArtARTs36\GitHandler\Exceptions\PreviousCherryPickIsNowEmpty;

/**
 * Git Index: (git add, git reset, git rm, ...)
 */
interface GitIndexCommand
{
    /**
     * Add file/files to git index
     * @git-command git add $file
     * @git-command git add $file $file $file
     * @param string|array<string> $file - file name to git added
     */
    public function add($file, bool $force = false): bool;

    /**
     * Remove file/files from git index
     * @git-command git rm $file
     * @git-command git rm $file1 $file2 ...
     * @param string|array<string> $files
     */
    public function remove($files, bool $force = false): void;

    /**
     * Remove cached file/files from git index
     * @git-command git rm --cached $file
     * @git-command git rm --cached $file1 $file2 ...
     * @param string|array<string> $files
     */
    public function removeCached($files, bool $force = false): void;

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

    /**
     * Rollback files state
     * @git-command git checkout HEAD $paths
     * @param string|array<string> $paths
     */
    public function rollback($paths): void;

    /**
     * Checkout to paths
     * @git-command git checkout $path
     * @param string $path
     * @throws BranchNotFound
     */
    public function checkout(string $path, bool $merge = false): bool;

    /**
     * Cherry pick
     * @git-command git cherry-pick $commitSha
     * @throws BadRevision
     * @throws PreviousCherryPickIsNowEmpty
     */
    public function cherryPick(string $commitSha): void;
}
