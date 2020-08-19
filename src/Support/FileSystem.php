<?php

namespace ArtARTs36\GitHandler\Support;

use ArtARTs36\GitHandler\Exceptions\PathIncorrect;

/**
 * Class FileSystem
 * @package ArtARTs36\GitHandler\Support
 */
class FileSystem
{
    /**
     * @param string $path
     * @return bool
     */
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

    /**
     * @param string $path
     * @return string
     */
    public static function belowPath(string $path): string
    {
        // For not exists Path
        if (!file_exists($path)) {
            $array = explode(DIRECTORY_SEPARATOR, $path);

            if (count($array) < 2) {
                throw new PathIncorrect($path);
            }

            $last = array_key_last($array);

            return implode(DIRECTORY_SEPARATOR, array_slice($array, 0, $last));
        }

        // For exists Path

        return realpath($path . '/../');
    }

    /**
     * @param string $path
     * @return mixed
     */
    public static function endFolder(string $path)
    {
        // For not exists Path
        if (!file_exists($path)) {
            $array = explode(DIRECTORY_SEPARATOR, $path);

            return end($array);
        }

        // For exists Path
        if (is_dir($path)) {
            return pathinfo($path, PATHINFO_BASENAME);
        }

        $dir = pathinfo($path, PATHINFO_DIRNAME);

        $array = explode(DIRECTORY_SEPARATOR, $dir);

        return end($array);
    }

    /**
     * @param string $file
     * @return bool
     */
    public static function isPseudoFile(string $file): bool
    {
        $array = explode('.', $file);

        return count($array) === 2;
    }
}
