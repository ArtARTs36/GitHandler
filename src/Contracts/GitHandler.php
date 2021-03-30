<?php

namespace ArtARTs36\GitHandler\Contracts;

use ArtARTs36\GitHandler\Exceptions\BranchNotFound;

interface GitHandler extends Taggable, Addable, HasRemotes, Pushable, Initable, Logable, Configurable, Versionable
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

    /**
     * equals: git status
     */
    public function status(bool $short = false): string;

    public function getDir(): string;

    /**
     * equals: git clone <url> <folder>
     */
    public function clone(string $url, ?string $branch = null): bool;

    /**
     * equals: git stash
     */
    public function stash(?string $message = null): bool;

    /**
     * equals: git commit -m=$message
     */
    public function commit(string $message, bool $amend = false): bool;

    /**
     * equals: git fetch
     */
    public function fetch(): void;

    public function pathToGitFolder(): string;

    public function getInfoPath(): string;

    public function getHtmlPath(): string;

    public function help(): string;
}
