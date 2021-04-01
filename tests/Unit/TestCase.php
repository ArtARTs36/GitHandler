<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Contracts\FileSystem;
use ArtARTs36\GitHandler\Contracts\HasRemotes;
use ArtARTs36\GitHandler\Data\Remotes;
use ArtARTs36\GitHandler\Git;
use ArtARTs36\GitHandler\GitSimpleFactory;
use ArtARTs36\GitHandler\Logger;
use ArtARTs36\GitHandler\Tests\Support\ArrayFileSystem;
use ArtARTs36\ShellCommand\ShellCommand;
use ArtARTs36\Str\Str;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    protected $fileSystem;

    public function setUp(): void
    {
        parent::setUp();

        $this->fileSystem = new ArrayFileSystem();
    }

    protected function mockGit(string $shellResult, string $dir = null): Git
    {
        $dir = $dir ?? __DIR__ . '/../libraries/';

        return new class($dir, $shellResult, $this->fileSystem) extends Git {
            private $shellResult;

            public function __construct(
                string $dir,
                string $shellResult,
                FileSystem $fileSystem,
                string $executor = 'git'
            ) {
                parent::__construct(
                    $dir,
                    new Logger(),
                    GitSimpleFactory::factoryConfigReader(),
                    $fileSystem,
                    $executor
                );

                $this->shellResult = $shellResult;
            }

            protected function executeCommand(ShellCommand $command): ?Str
            {
                if ($this->shellResult === null) {
                    return null;
                }

                return Str::make($this->shellResult);
            }
        };
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
        };
    }
}
