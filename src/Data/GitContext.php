<?php

namespace ArtARTs36\GitHandler\Data;

use ArtARTs36\GitHandler\Support\ToArray;

class GitContext
{
    use ToArray;

    protected $rootDir;

    protected $gitDir;

    public function __construct(string $rootDir, string $gitDir)
    {
        $this->rootDir = $rootDir;
        $this->gitDir = $gitDir;
    }

    public static function make(string $rootDir, ?string $gitFolder = '.git'): self
    {
        return new self($rootDir, $rootDir . DIRECTORY_SEPARATOR . $gitFolder);
    }

    public function getRootDir(): string
    {
        return $this->rootDir;
    }

    public function getRootFolder(): string
    {
        return pathinfo($this->rootDir, PATHINFO_BASENAME);
    }

    public function getGitDir(): string
    {
        return $this->gitDir;
    }

    public function getRefsDir(): string
    {
        return $this->gitDir . DIRECTORY_SEPARATOR . 'refs';
    }
}
