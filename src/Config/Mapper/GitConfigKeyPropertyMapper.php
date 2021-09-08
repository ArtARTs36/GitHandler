<?php

namespace ArtARTs36\GitHandler\Config\Mapper;

use ArtARTs36\GitHandler\Attributes\Loader\AttributeLoader;

class GitConfigKeyPropertyMapper
{
    private $attributes;

    /** @var array<class-string, array<\Attribute> */
    private static $cache = [];

    public function __construct(AttributeLoader $loader)
    {
        $this->attributes = $loader;
    }

    public static function map($object): array
    {
        return (new static(AttributeLoader::make()))->doMap(get_class($object));
    }

    public function doMap(string $class): array
    {
        if (! isset(static::$cache[$class])) {
            static::$cache[$class] = array_map('strval', $this->attributes->fromProperties($class));
        }

        return static::$cache[$class];
    }
}
