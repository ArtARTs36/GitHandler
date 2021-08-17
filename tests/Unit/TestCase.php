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

    protected function mockHasRemotes(string $fetch, ?string $push = null): HasRemotes
    {
        $push = $push ?? $fetch;

        return new class($fetch, $push) implements HasRemotes {
            private $fetch;

            private $push;

            public function __construct(string $fetch, string $push)
            {
                $this->fetch = $fetch;
                $this->push = $push;
            }

            public function showRemote(): Remotes
            {
                return new Remotes(new Str($this->fetch), new Str($this->push));
            }

            public function addRemote(string $shortName, string $url): bool
            {
                return true;
            }

            public function removeRemote(string $shortName): bool
            {
                return true;
            }

            public function hasAnyRemoteUrl(string $url): bool
            {
                return true;
            }
        };
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
