<?php

namespace ArtARTs36\GitHandler\Contracts;

use ArtARTs36\GitHandler\Exceptions\BranchNotFound;

interface GitHandler extends
    Taggable,
    Addable,
    HasRemotes,
    Pushable,
    Initable,
    Logable,
    Configurable,
    Versionable,
    HasPaths,
    Statusable,
    Stashable
{
    /**
     * equals: git pull
     * equals: git pull <branch>
     */
    public function pull(?string $branch = null): bool;

    /**
     * equals: git checkout <branch>
     * @throws BranchNotFound
     */
    public function checkout(string $branch): bool;

    public function getDir(): string;

    /**
     * equals: git clone <url> -b <branch>
     */
    public function clone(string $url, ?string $branch = null, ?string $folder = null): bool;

    /**
     * equals: git commit -m=$message
     */
    public function commit(string $message, bool $amend = false): bool;

    /**
     * equals: git fetch
     */
    public function fetch(): void;

    public function pathToGitFolder(): string;

    public function help(): string;
}
