<?php

namespace ArtARTs36\GitHandler\DocBuilder;

class ClassInfo
{
    public $fullName;

    public $filePath;

    public $projectFilePath;

    public function __construct(string $fullName, string $filePath, string $projectFilePath)
    {
        $this->fullName = $fullName;
        $this->filePath = $filePath;
        $this->projectFilePath = $projectFilePath;
    }
}
