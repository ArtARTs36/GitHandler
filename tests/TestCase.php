<?php

namespace ArtARTs36\GitHandler\Tests;

use ArtARTs36\GitHandler\Git;
use ArtARTs36\GitHandler\GitSimpleFactory;
use ArtARTs36\GitHandler\Logger;
use ArtARTs36\GitHandler\Support\LocalFileSystem;
use ArtARTs36\ShellCommand\ShellCommand;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    protected function mockGit(string $shellResult, string $dir = null): Git
    {
        $dir = $dir ?? __DIR__ . '/../../';

        return new class($dir, $shellResult, 'git') extends Git {
            private $shellResult;

            public function __construct(string $dir, string $shellResult, string $executor = 'git')
            {
                parent::__construct(
                    $dir,
                    new Logger(),
                    GitSimpleFactory::factoryConfigReader(),
                    new LocalFileSystem(),
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
