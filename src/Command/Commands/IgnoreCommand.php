<?php

namespace ArtARTs36\GitHandler\Command\Commands;

use ArtARTs36\GitHandler\Concerns\SwitchFolder;
use ArtARTs36\GitHandler\Contracts\Commands\GitIgnoreCommand;
use ArtARTs36\FileSystem\Contracts\FileSystem;
use ArtARTs36\GitHandler\Data\GitContext;
use ArtARTs36\Str\Str;

class IgnoreCommand implements GitIgnoreCommand
{
    use SwitchFolder;

    protected $context;

    protected $fileSystem;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(GitContext $context, FileSystem $fileSystem)
    {
        $this->context = $context;
        $this->fileSystem = $fileSystem;
        $this->seeToRoot();
    }

    /**
     * @return array<string>
     */
    public function files(): array
    {
        $path = $this->getPath();

        if (! $this->fileSystem->exists($path)) {
            return [];
        }

        return array_map('trim', (new Str($this->fileSystem->getFileContent($this->getPath())))->lines());
    }

    public function add(string $path): bool
    {
        $gitIgnore = $this->getPath();

        $content = $this->fileSystem->exists($gitIgnore) ? $this->fileSystem->getFileContent($gitIgnore) : '';
        $content = new Str($content);

        if (! $content->isEmpty()) {
            $content = $content->append("\n");
        }

        return $this->fileSystem->createFile($gitIgnore, $content->append($path));
    }

    public function delete(string $path): bool
    {
        if (! $this->fileSystem->exists($gitignore = $this->getPath())) {
            return false;
        }

        $content = Str::make($this->fileSystem->getFileContent($gitignore))->lines();
        $excepts = [];

        foreach ($content as $index => $line) {
            if ($line->trim()->equals($path)) {
                $excepts[] = $index;
            }
        }

        return $this->fileSystem->createFile($gitignore, $content->exceptKeys($excepts)->implode("\n"));
    }

    public function has(string $path): bool
    {
        if (! $this->isFileExists()) {
            return false;
        }

        return (new Str($this->fileSystem->getFileContent($this->getPath())))
            ->hasLine($path);
    }

    /**
     * @codeCoverageIgnore
     */
    public function getPath(): string
    {
        return $this->folder . DIRECTORY_SEPARATOR . '.gitignore';
    }

    final protected function isFileExists(): bool
    {
        return $this->fileSystem->exists($this->getPath());
    }
}
