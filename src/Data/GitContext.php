<?php

namespace ArtARTs36\GitHandler\Data;

use ArtARTs36\GitHandler\Support\ToArray;

class GitContext
{
    use ToArray;

    protected $rootDir;

    protected $gitDir;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(string $rootDir, string $gitDir)
    {
        $this->rootDir = $rootDir;
        $this->gitDir = $gitDir;
    }

    public static function make(string $rootDir, ?string $gitFolder = '.git'): self
    {
        return new static($rootDir, $rootDir . DIRECTORY_SEPARATOR . $gitFolder);
    }

    /**
     * @codeCoverageIgnore
     */
    public function getRootDir(): string
    {
        return $this->rootDir;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getGitDir(): string
    {
        return $this->gitDir;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getRefsDir(): string
    {
        return $this->gitDir . DIRECTORY_SEPARATOR . 'refs';
    }
}
