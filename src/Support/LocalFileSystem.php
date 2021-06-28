<?php

namespace ArtARTs36\GitHandler\Support;

use ArtARTs36\GitHandler\Contracts\FileSystem;
use ArtARTs36\GitHandler\Exceptions\FileNotFound;
use ArtARTs36\GitHandler\Exceptions\PathIncorrect;
use ArtARTs36\Str\Str;

class LocalFileSystem implements FileSystem
{
    public function removeDir(string $path): bool
    {
        if (is_file($path)) {
            return unlink($path);
        }

        if (is_dir($path)) {
            array_map(function ($file) use ($path) {
                static::removeDir($path . DIRECTORY_SEPARATOR . $file);
            }, array_diff(scandir($path), ['.', '..']));

            return rmdir($path);
        }

        return true;
    }

    public function belowPath(Str $path): string
    {
        // For not exists Path
        if (! file_exists($path)) {
            $array = $path->explode(DIRECTORY_SEPARATOR);

            if ($array->count() < 2) {
                throw new PathIncorrect($path);
            }

            return $array->slice(0, $array->count() - 1)->implode(DIRECTORY_SEPARATOR);
        }

        // For exists Path

        return realpath($path . '/../');
    }

    public function endFolder(string $path): string
    {
        // For not exists Path
        if (! file_exists($path)) {
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
        return ! empty(pathinfo($file, PATHINFO_EXTENSION));
    }

    /**
     * @codeCoverageIgnore
     */
    public function createDir(string $path, int $permissions = 0755): bool
    {
        if (! file_exists($path)) {
            return mkdir($path, $permissions, true);
        }

        return true;
    }

    public function exists(string $path): bool
    {
        return file_exists($path);
    }

    /**
     * @codeCoverageIgnore
     */
    public function createFile(string $path, string $content): bool
    {
        return file_put_contents($path, $content) !== false;
    }

    public function getFileContent(string $path): Str
    {
        if (! $this->exists($path)) {
            throw new FileNotFound($path);
        }

        return Str::make(file_get_contents($path));
    }

    /**
     * @codeCoverageIgnore
     */
    public function removeFile(string $path): bool
    {
        return @unlink($path);
    }
}
