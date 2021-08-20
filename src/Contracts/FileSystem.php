<?php

namespace ArtARTs36\GitHandler\Contracts;

use ArtARTs36\GitHandler\Exceptions\FileNotFound;

interface FileSystem
{
    public function removeFile(string $path): bool;

    public function removeDir(string $path): bool;

    /**
     * @return array<string>
     */
    public function getFromDirectory(string $path): array;

    public function downPath(string $path): string;

    public function endFolder(string $path): string;

    public function createDir(string $path, int $permissions = 0755): bool;

    public function exists(string $path): bool;

    public function createFile(string $path, string $content): bool;

    /**
     * @throws FileNotFound
     */
    public function getFileContent(string $path): string;

    /**
     * @throws FileNotFound
     */
    public function getLastUpdateDate(string $path): \DateTimeInterface;
}
