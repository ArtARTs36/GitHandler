<?php

namespace ArtARTs36\GitHandler\Files;

use ArtARTs36\Str\Str;
use ArtARTs36\Str\StrCollection;

class Ignore extends GitFile
{
    public function files(): StrCollection
    {
        $path = $this->getPathToFile();

        if (! $this->files->exists($path)) {
            return new StrCollection([]);
        }

        return Str::make($this->files->getFileContent($this->getPathToFile()))->lines()->trim();
    }

    public function add(string $path): bool
    {
        $content = $this->fileExists() ?
            $this->getContent() :
            Str::fromEmpty();

        if (! $content->isEmpty()) {
            $content = $content->appendLine('');
        }

        return $this->createFile($content->append($path));
    }

    public function has(string $path): bool
    {
        if (! $this->fileExists()) {
            return false;
        }

        return $this->getContent()->hasLine($path);
    }

    /**
     * @codeCoverageIgnore
     */
    public function getPathToFile(): string
    {
        return $this->git->getDir()->append('/.gitignore');
    }
}
