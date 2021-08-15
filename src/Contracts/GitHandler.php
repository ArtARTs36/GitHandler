<?php

namespace ArtARTs36\GitHandler\Contracts;

interface GitHandler extends Versionable
{
    /**
     * equals: git pull
     * equals: git pull <branch>
     */
    public function pull(?string $branch = null): bool;

    public function getDir(): string;

    public function pathToGitFolder(): string;
}
