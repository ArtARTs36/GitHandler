<?php

namespace ArtARTs36\GitHandler\Support;

use ArtARTs36\FileSystem\Contracts\FileSystem;
use ArtARTs36\GitHandler\Exceptions\FileNotFound;
use ArtARTs36\Str\Str;

class LocalFileSystem implements FileSystem
{
    protected $fileDateGetter;

    public function __construct(?callable $fileDateGetter = null)
    {
        $this->fileDateGetter = $fileDateGetter ?? 'filemtime';
    }

    public function removeFile(string $path): bool
    {
        if (! $this->exists($path)) {
            throw new FileNotFound($path);
        }

        return unlink($path);
    }

    public function removeDir(string $path): bool
    {
        if (! $this->exists($path)) {
            return true;
        }

        if (is_file($path)) {
            return $this->removeFile($path);
        }

        if (is_dir($path)) {
            foreach ($this->getFromDirectory($path) as $file) {
                $this->removeDir($file);
            }

            return rmdir($path);
        }

        return true;
    }

    /**
     * @return array<string>
     */
    public function getFromDirectory(string $path): array
    {
        return glob($this->getAbsolutePath($path) . '/*');
    }

    public function downPath(string $path): string
    {
        if ($this->exists($path)) {
            return $this->getAbsolutePath($path . '/../');
        }

        return dirname($path);
    }

    public function createDir(string $path, int $permissions = 0755): bool
    {
        if (! $this->exists($path)) {
            return mkdir($path, $permissions, true);
        }

        return true;
    }

    public function exists(string $path): bool
    {
        return file_exists($path);
    }

    public function createFile(string $path, string $content): bool
    {
        return file_put_contents($path, $content) !== false;
    }

    public function getFileContent(string $path): string
    {
        if (! $this->exists($path)) {
            throw new FileNotFound($path);
        }

        return file_get_contents($path);
    }

    public function getLastUpdateDate(string $path): \DateTimeInterface
    {
        if (! $this->exists($path)) {
            throw new FileNotFound($path);
        }

        $dateGetter = $this->fileDateGetter;

        return (new \DateTime())->setTimestamp($dateGetter($path));
    }

    public function getAbsolutePath(string $path): string
    {
        if (! $this->exists($path)) {
            throw new FileNotFound($path);
        }

        return realpath($path);
    }

    public function getTmpDir(): string
    {
        return sys_get_temp_dir();
    }

    public function getChmod(string $path): int
    {
        return Str::make(sprintf('%o', fileperms($path)))->cut(null, -4)->toInteger();
    }
}
