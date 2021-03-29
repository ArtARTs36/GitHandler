<?php

namespace ArtARTs36\GitHandler\Contracts;

interface FileSystem
{
    public function removeDir(string $path): bool;

    public function belowPath(string $path): string;

    public function endFolder(string $path): string;

    public function createDir(string $path, int $permissions): bool;
}
