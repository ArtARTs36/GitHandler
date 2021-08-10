<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Contracts\FileSystem;
use ArtARTs36\GitHandler\Contracts\HasRemotes;
use ArtARTs36\GitHandler\Contracts\LogParser;
use ArtARTs36\GitHandler\Data\Remotes;
use ArtARTs36\GitHandler\Git;
use ArtARTs36\GitHandler\GitSimpleFactory;
use ArtARTs36\GitHandler\Logger;
use ArtARTs36\GitHandler\Tests\Support\ArrayFileSystem;
use ArtARTs36\GitHandler\Tests\Support\QueueCommandExecutor;
use ArtARTs36\ShellCommand\ShellCommand;
use ArtARTs36\ShellCommand\ShellCommander;
use ArtARTs36\Str\Str;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    protected $fileSystem;

    public function setUp(): void
    {
        parent::setUp();

        $this->fileSystem = new ArrayFileSystem();
    }

    protected function mockGit($shellResult = null, ?string $dir = null, ?LogParser $logger = null): Git
    {
        $dir = $dir ?? __DIR__;

        $results = empty($shellResult) ? [''] : (array) $shellResult;

        return new Git(
            $dir,
            $logger ?? new Logger(),
            GitSimpleFactory::factoryConfigReader(),
            $this->fileSystem,
            new QueueCommandExecutor($results),
            new ShellCommander()
        );
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
                //
            }

            public function removeRemote(string $shortName): bool
            {
                // TODO: Implement removeRemote() method.
            }

            public function hasAnyRemoteUrl(string $url): bool
            {
                // TODO: Implement hasAnyRemoteUrl() method.
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
