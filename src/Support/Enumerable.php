<?php

namespace ArtARTs36\GitHandler\Support;

trait Enumerable
{
    /**
     * @codeCoverageIgnore
     */
    public static function cases(): array
    {
        static $cases = [];

        if (! array_key_exists(static::class, $cases)) {
            $cases[static::class] = (new \ReflectionClass(static::class))->getConstants();
        }

        return $cases[static::class];
    }
}
