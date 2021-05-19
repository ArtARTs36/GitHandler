<?php

namespace ArtARTs36\GitHandler\Files;

use ArtARTs36\GitHandler\Contracts\FileSystem;
use ArtARTs36\GitHandler\Contracts\HasDirectory;
use ArtARTs36\Str\Str;

class Attributes
{
    protected $git;

    protected $files;

    public function __construct(HasDirectory $git, FileSystem $files)
    {
        $this->git = $git;
        $this->files = $files;
    }

    public function addExportIgnore(string ...$paths): bool
    {
        $content = $this->fileExists() ? $this->getContent() : Str::fromEmpty();

        if ($content->isEmpty()) {
            $content = $content->appendLine('');
        }

        $content = $content->append($this->wraps($paths, 'export-ignore'));

        return $this->files->createFile($this->getPathToFile(), $content);
    }

    /**
     * @codeCoverageIgnore
     */
    public function getPathToFile(): string
    {
        return $this->git->getDir()->append('/.gitattributes');
    }

    protected function fileExists(): bool
    {
        return $this->files->exists($this->getPathToFile());
    }

    protected function getContent(): Str
    {
        return $this->files->getFileContent($this->getPathToFile());
    }

    protected function wraps(array $values, string $attribute): string
    {
        $content = '';

        foreach ($values as $value) {
            $content .= $this->wrap($value, $attribute);
        }

        return $content;
    }

    protected function wrap(string $value, string $attribute): string
    {
        return $value . "\t\t" . $attribute;
    }
}
