<?php

namespace ArtARTs36\GitHandler\DocBuilder;

class FolderStatistic
{
    public $path;

    public $codeFiles;

    public $codeLines;

    public function __construct(string $path, int $codeFiles, int $codeLines)
    {
        $this->path = $path;
        $this->codeFiles = $codeFiles;
        $this->codeLines = $codeLines;
    }
}
