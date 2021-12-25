<?php

namespace ArtARTs36\GitHandler\DocBuilder;

use ArtARTs36\FileSystem\Contracts\FileSystem;
use ArtARTs36\Str\Facade\Str;

class FolderStatist
{
    private $files;

    public function __construct(FileSystem $files)
    {
        $this->files = $files;
    }

    public function calculate(string $path): FolderStatistic
    {
        $codeLines = 0;
        $codeFiles = 0;

        foreach ($this->getFromDirectory($path) as $file) {
            if ($this->isCode($file)) {
                $codeFiles++;

                $codeLines += count(file($file));
            }
        }

        return new FolderStatistic($path, $codeFiles, $codeLines);
    }

    private function isCode(string $file): bool
    {
        return Str::endsWith($file, '.php');
    }

    private function getFromDirectory(string $path): array
    {
        $files = [];

        foreach ($this->files->getFromDirectory($path) as $file) {
            if (is_dir($file)) {
                array_push($files, ...$this->getFromDirectory($file));
            } else {
                $files[] = $file;
            }
        }

        return $files;
    }
}
