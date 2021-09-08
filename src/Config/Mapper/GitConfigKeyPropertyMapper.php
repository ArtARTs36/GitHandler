<?php

namespace ArtARTs36\GitHandler\Config\Mapper;

use ArtARTs36\GitHandler\Attributes\Loader\AttributeLoader;

class GitConfigKeyPropertyMapper
{
    private $attributes;

    /** @var array<class-string, array<\Attribute> */
    private static $cache = [];

    final public function __construct(AttributeLoader $loader)
    {
        $this->attributes = $loader;
    }

    public static function make(): self
    {
        return (new self(AttributeLoader::make()));
    }

    public function map($object): array
    {
        return $this->doMap(is_object($object) ? get_class($object) : $object);
    }

    public function createObjectFromArray(string $class, array $data): object
    {
        $reflector = new \ReflectionClass($class);

        $keyOnProperty = array_flip($this->doMap($class));

        $args = [];

        foreach ($data as $key => $value) {
            if (! isset($keyOnProperty[$key])) {
                continue;
            }

            $args[$keyOnProperty[$key]] = $value;
        }

        return $reflector->newInstanceArgs($args);
    }

    protected function doMap(string $class): array
    {
        if (! isset(static::$cache[$class])) {
            static::$cache[$class] = array_map('strval', $this->attributes->fromProperties($class));
        }

        return static::$cache[$class];
    }
}
