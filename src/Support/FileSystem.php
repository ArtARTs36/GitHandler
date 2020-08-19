<?php

namespace ArtARTs36\GitHandler\Support;

class FileSystem
{
    public static function removeDir(string $path): bool
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
}
