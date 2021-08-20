<?php

namespace ArtARTs36\GitHandler\Support;

use ArtARTs36\GitHandler\Contracts\FileSystem;
use ArtARTs36\GitHandler\Exceptions\FileNotFound;
use ArtARTs36\GitHandler\Exceptions\PathIncorrect;

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
        return glob(realpath($path) . '/*');
    }

    public function downPath(string $path): string
    {
        if ($this->exists($path)) {
            return realpath($path . '/../');
        }

        return dirname($path);
    }

    public function endFolder(string $path): string
    {
        // For not exists Path
        if (! $this->exists($path)) {
            $array = explode(DIRECTORY_SEPARATOR, $path);

            $end = end($array);

            if (! static::isPseudoFile($end)) {
                return $end;
            }

            if (count($array) > 1) {
                return $array[array_key_last($array) - 1];
            }

            return '';
        }

        // For exists Path
        if (is_dir($path)) {
            return pathinfo($path, PATHINFO_BASENAME);
        }

        $dir = pathinfo($path, PATHINFO_DIRNAME);

        $array = explode(DIRECTORY_SEPARATOR, $dir);

        return end($array);
    }

    public function isPseudoFile(string $file): bool
    {
        $array = explode('.', $file);

        return count($array) > 1;
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
}
