<?php

namespace ArtARTs36\GitHandler\Contracts;

interface GitHandler extends
    Addable,
    HasRemotes,
    Pushable,
    Initable,
    Logable,
    Configurable,
    Versionable,
    Statusable,
    Stashable,
    Fetchable,
    HasBranches
{
    /**
     * equals: git pull
     * equals: git pull <branch>
     */
    public function pull(?string $branch = null): bool;

    public function getDir(): string;

    /**
     * equals: git clone <url> -b <branch>
     */
    public function clone(string $url, ?string $branch = null, ?string $folder = null): bool;

    /**
     * equals: git commit -m=$message
     */
    public function commit(string $message, bool $amend = false): bool;

    public function autoCommit(string $message, bool $amend = false): bool;

    public function pathToGitFolder(): string;
}
