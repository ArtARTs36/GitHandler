<?php

namespace ArtARTs36\GitHandler\Contracts\Commands;

/**
 * Git Files
 */
interface GitFileCommand
{
    /**
     * Create file in git repository
     * @return string - absolute path to file
     */
    public function createFile(string $name, string $content, ?string $folder = null): string;

    /**
     * Create folder in git repository
     */
    public function createFolder(string $name): self;

    /**
     * Get file content from git repository
     */
    public function getContent(string $name): string;
}
