<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Contracts\Handler\HasRemotes;
use ArtARTs36\GitHandler\Data\Remotes;
use ArtARTs36\GitHandler\Tests\Support\ArrayFileSystem;
use ArtARTs36\Str\Str;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    protected $fileSystem;

    public function setUp(): void
    {
        parent::setUp();

        $this->fileSystem = new ArrayFileSystem();
    }

    protected function getPropertyValueOfObject($object, string $property)
    {
        $getter = function () use ($property) {
            return $this->$property;
        };

        return $getter->call($object);
    }

    protected function callMethodFromObject($object, string $method, ...$args)
    {
        $caller = function () use ($method, $args) {
            return $this->$method(...$args);
        };

        return $caller->call($object);
    }
}
