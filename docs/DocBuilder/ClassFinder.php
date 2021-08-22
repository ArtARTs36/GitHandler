<?php

namespace ArtARTs36\GitHandler\DocBuilder;

use ArtARTs36\Str\Facade\Str;

class ClassFinder
{
    protected static $projectDir;

    public static function setProjectDir(string $dir): void
    {
        static::$projectDir = realpath($dir);
    }

    public static function find(string $class): ?ClassInfo
    {
        static $composer = null;

        if ($composer === null) {
            $composer = require_once __DIR__ . '/../../vendor/composer/autoload_classmap.php';
        }

        if (! array_key_exists($class, $composer)) {
            return null;
        }

        $path = $composer[$class];

        return new ClassInfo($class, $path, Str::delete($path, [static::$projectDir]));
    }
}
