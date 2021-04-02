<?php

namespace ArtARTs36\GitHandler;

use ArtARTs36\GitHandler\Contracts\FileSystem;
use ArtARTs36\GitHandler\Contracts\GitHandler;
use ArtARTs36\Str\Str;

class Ignore
{
    protected $git;

    protected $fileSystem;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(GitHandler $git, FileSystem $fileSystem)
    {
        $this->git = $git;
        $this->fileSystem = $fileSystem;
    }

    /**
     * @return array<string>
     */
    public function files(): array
    {
        $path = $this->getPathToFile();

        if (! $this->fileSystem->exists($path)) {
            return [];
        }

        return array_map('trim', (new Str($this->fileSystem->getFileContent($this->getPathToFile())))->lines());
    }

    public function add(string $path): bool
    {
        $gitIgnore = $this->getPathToFile();

        $content = $this->fileSystem->exists($gitIgnore) ? $this->fileSystem->getFileContent($gitIgnore) : '';
        $content = new Str($content);

        if (! $content->isEmpty()) {
            $content = $content->append("\n");
        }

        return $this->fileSystem->createFile($gitIgnore, $content->append($path));
    }

    public function has(string $path): bool
    {
        if (! $this->fileSystem->exists($this->getPathToFile())) {
            return false;
        }

        return (new Str($this->fileSystem->getFileContent($this->getPathToFile())))
            ->hasLine($path);
    }

    public function getPathToFile(): string
    {
        return $this->git->getDir() . '/.gitignore';
    }
}
