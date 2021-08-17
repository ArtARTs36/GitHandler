<?php

namespace ArtARTs36\GitHandler\Command\Commands\Contracts;

/**
 * Git Files
 */
interface GitFileCommand
{
    /**
     * @return string - absolute path to file
     */
    public function createFile(string $name, string $content, ?string $folder = null): string;

    /**
     * Create folder into git repository
     */
    public function createFolder(string $name): self;
}
