<?php

namespace ArtARTs36\GitHandler\DocBuilder;

use ArtARTs36\Str\Facade\Str;

final class Project
{
    private $rootDir;

    public function __construct(string $rootDir)
    {
        $this->rootDir = $rootDir;
    }

    public function getRootDir(): string
    {
        return $this->rootDir;
    }

    public function relativePathToFile(string $file): string
    {
        return Str::delete($file, [$this->rootDir]);
    }
}
