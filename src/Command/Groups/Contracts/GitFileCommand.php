<?php

namespace ArtARTs36\GitHandler\Command\Groups\Contracts;

interface GitFileCommand
{
    /**
     * @return string - absolute path to file
     */
    public function createFile(string $name, string $content, ?string $folder = null): string;

    public function createFolder(string $name): self;
}
