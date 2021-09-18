<?php

namespace ArtARTs36\GitHandler\Config\Mapper;

use ArtARTs36\GitHandler\Attributes\Loader\AttributeLoader;
use ArtARTs36\GitHandler\Contracts\Config\ConfigSubject;

class GitConfigKeyPropertyMapper
{
    protected $attributes;

    /** @var array<class-string, array<string>> */
    private static $cache = [];

    final public function __construct(AttributeLoader $loader)
    {
        $this->attributes = $loader;
    }

    /**
     * Make self instance
     */
    public static function make(): self
    {
        return (new self(AttributeLoader::make()));
    }

    /**
     * @param class-string<ConfigSubject> $class
     * @return array<string, string>
     * @throws \ReflectionException
     */
    public function map(string $class): array
    {
        if (! isset(static::$cache[$class])) {
            static::$cache[$class] = array_map('strval', $this->attributes->fromProperties($class));
        }

        return static::$cache[$class];
    }

    /**
     * @param class-string $class
     * @param array<string, mixed> $data
     * @throws \ReflectionException
     */
    public function createObjectFromArray(string $class, array $data):object
    {
        $reflector = new \ReflectionClass($class);

        $keyOnProperty = array_flip($this->map($class));

        $args = [];

        foreach ($data as $key => $value) {
            if (! isset($keyOnProperty[$key])) {
                continue;
            }

            $args[$keyOnProperty[$key]] = $value;
        }

        return $reflector->newInstanceArgs($args);
    }
}
