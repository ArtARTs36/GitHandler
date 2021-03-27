<?php

namespace ArtARTs36\GitHandler\Contracts;

use ArtARTs36\GitHandler\Data\Remotes;
use ArtARTs36\GitHandler\Exceptions\BranchNotFound;

interface GitHandler extends Taggable
{
    /**
     * equals: git pull
     * equals: git pull <branch>
     */
    public function pull(?string $branch = null): bool;

    /**
     * equals: git init
     */
    public function init(): bool;

    /**
     * equals: git checkout <branch>
     * @throws BranchNotFound
     */
    public function checkout(string $branch): bool;

    /**
     * equals: git status
     */
    public function status(bool $short = false): string;

    /**
     * @param string $file - file name to git added
     */
    public function add(string $file): bool;

    public function getDir(): string;

    /**
     * equals: git clone <url> <folder>
     */
    public function clone(string $url, ?string $branch = null): bool;

    /**
     * equals: git stash
     */
    public function stash(?string $message = null): bool;

    public function showRemote(): Remotes;
}
