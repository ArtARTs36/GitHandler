<?php

namespace ArtARTs36\GitHandler\Contracts;

interface GitHandler extends
    HasRemotes,
    Versionable
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

    public function pathToGitFolder(): string;
}
