<?php

namespace ArtARTs36\GitHandler\Command\Commands;

use ArtARTs36\GitHandler\Contracts\Commands\GitIgnoreCommand;
use ArtARTs36\FileSystem\Contracts\FileSystem;
use ArtARTs36\GitHandler\Data\GitContext;
use ArtARTs36\Str\Str;

class IgnoreCommand implements GitIgnoreCommand
{
    protected $context;

    protected $fileSystem;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(GitContext $context, FileSystem $fileSystem)
    {
        $this->context = $context;
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

    /**
     * @codeCoverageIgnore
     */
    public function getPathToFile(): string
    {
        return $this->context->getRootDir() . '/.gitignore';
    }
}
