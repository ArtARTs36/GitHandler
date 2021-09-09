<?php

namespace ArtARTs36\GitHandler\Attributes\Loader;

use ArtARTs36\GitHandler\Contracts\Attribute\AttributeLoadDriver;

final class AttributeLoader
{
    private $driver;

    public function __construct(AttributeLoadDriver $driver)
    {
        $this->driver = $driver;
    }

    public static function make(): self
    {
        $driver = PHP_VERSION_ID < 80000 ? new TokenDriver() : new NativeDriver();

        return new self($driver);
    }

    /**
     * @param class-string $class
     * @return array<string, \Attribute>
     */
    public function fromProperties(string $class): array
    {
        return $this->driver->fromProperties(new \ReflectionClass($class));
    }
}
