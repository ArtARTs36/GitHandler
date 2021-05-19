<?php

namespace ArtARTs36\GitHandler\Files;

use ArtARTs36\GitHandler\Contracts\FileSystem;
use ArtARTs36\GitHandler\Contracts\GitHandler;
use ArtARTs36\Str\Str;

abstract class GitFile
{
    abstract public function getPathToFile(): string;

    protected $git;

    protected $files;

    public function __construct(GitHandler $git, FileSystem $files)
    {
        $this->git = $git;
        $this->files = $files;
    }

    public function fileExists(): bool
    {
        return $this->files->exists($this->getPathToFile());
    }

    protected function getContent(): Str
    {
        return $this->files->getFileContent($this->getPathToFile());
    }

    protected function createFile(string $content): bool
    {
        return $this->files->createFile($this->getPathToFile(), $content);
    }
}
