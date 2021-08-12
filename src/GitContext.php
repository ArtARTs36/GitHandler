<?php

namespace ArtARTs36\GitHandler;

class GitContext
{
    protected $rootDir;

    protected $gitDir;

    public function __construct(string $rootDir, string $gitDir)
    {
        $this->rootDir = $rootDir;
        $this->gitDir = $gitDir;
    }

    public static function make(string $rootDir, ?string $gitFolder = '.git'): self
    {
        return new static($rootDir, $rootDir . DIRECTORY_SEPARATOR . $gitFolder);
    }

    public function getRootDir(): string
    {
        return $this->rootDir;
    }

    public function getGitDir(): string
    {
        return $this->gitDir;
    }
}
