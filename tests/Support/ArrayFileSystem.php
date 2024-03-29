<?php

namespace ArtARTs36\GitHandler\Tests\Support;

use ArtARTs36\FileSystem\Contracts\FileSystem;
use ArtARTs36\GitHandler\Exceptions\FileNotFound;
use ArtARTs36\FileSystem\Local\LocalFileSystem;
use ArtARTs36\Str\Facade\Str;

class ArrayFileSystem extends LocalFileSystem implements FileSystem
{
    protected $dirs = [];

    protected $files = [];

    public function removeFile(string $path): bool
    {
        if (! $this->exists($path)) {
            throw new FileNotFound($path);
        }

        unset($this->files[$path]);

        return true;
    }

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

    public function reset(): self
    {
        $this->dirs = [];
        $this->files = [];

        return $this;
    }

    public function getFileContent(string $path): string
    {
        if (! $this->exists($path)) {
            throw new FileNotFound($path);
        }

        return $this->files[$path];
    }

    public function getLastUpdateDate(string $path): \DateTimeInterface
    {
        if (! $this->exists($path)) {
            throw new FileNotFound($path);
        }

        return new \DateTime();
    }

    public function getFromDirectory(string $path): array
    {
        if (! array_key_exists($path, $this->dirs)) {
            return [];
        }

        $find = [];

        foreach (array_keys($this->files) as $file) {
            if (Str::contains($file, $path)) {
                $find[] = $file;
            }
        }

        return $find;
    }

    public function firstFile(): array
    {
        if (count($this->files) === 0) {
            return [];
        }

        return [key($this->files), reset($this->files)];
    }
}
