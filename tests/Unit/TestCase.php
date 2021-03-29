<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Contracts\FileSystem;
use ArtARTs36\GitHandler\Git;
use ArtARTs36\GitHandler\GitSimpleFactory;
use ArtARTs36\GitHandler\Logger;
use ArtARTs36\GitHandler\Tests\Support\ArrayFileSystem;
use ArtARTs36\ShellCommand\ShellCommand;

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

            protected function executeCommand(ShellCommand $command): ?string
            {
                return $this->shellResult;
            }
        };
    }
}
