<?php

namespace ArtARTs36\GitHandler\Contracts;

interface GitFileManager
{
    public function deleteFile(string $path): bool;

    public function createFolder(string $name): bool;

    /**
     * @return string - absolute path to file
     */
    public function createFile(string $name, string $content, ?string $folder = null): string;
}
