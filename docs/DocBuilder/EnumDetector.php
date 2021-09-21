<?php

namespace ArtARTs36\GitHandler\DocBuilder;

use ArtARTs36\GitHandler\Enum\Enumerable;

class EnumDetector
{
    /**
     * @param class-string $class
     */
    public static function is(string $class): bool
    {
        return class_exists($class) && array_key_exists(Enumerable::class, class_uses($class)) ?? false;
    }
}
