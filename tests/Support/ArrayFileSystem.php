<?php

namespace ArtARTs36\GitHandler\Tests\Support;

use ArtARTs36\GitHandler\Contracts\FileSystem;
use ArtARTs36\GitHandler\Support\LocalFileSystem;

class ArrayFileSystem extends LocalFileSystem implements FileSystem
{
    protected $dirs = [];

    protected $files = [];

    public function removeDir(string $path): bool
    {
        unset($this->dirs[$path]);

        return true;
    }

    public function createDir(string $path, int $permissions = 0755): bool
    {
        $this->dirs[$path] = $permissions;

        return true;
    }

    public function exists(string $path): bool
    {
        return array_key_exists($path, $this->dirs) || array_key_exists($path, $this->files);
    }

    public function createFile(string $path, string $content): bool
    {
        $this->files[$path] = $content;

        return true;
    }
}
