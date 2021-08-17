<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Command\GitCommandBuilder;
use ArtARTs36\GitHandler\Data\GitContext;
use ArtARTs36\GitHandler\Tests\Support\ArrayFileSystem;
use ArtARTs36\GitHandler\Tests\Support\V2QueueCommandExecutor;
use ArtARTs36\ShellCommand\ShellCommander;

abstract class V2TestCase extends \PHPUnit\Framework\TestCase
{
    /** @var GitCommandBuilder */
    protected $mockCommandBuilder;

    /** @var ArrayFileSystem */
    protected $mockFileSystem;

    /** @var V2QueueCommandExecutor */
    protected $mockCommandExecutor;

    /** @var GitContext */
    protected $mockGitContext;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockCommandBuilder = new GitCommandBuilder(new ShellCommander(), 'git', __DIR__);
        $this->mockFileSystem = new ArrayFileSystem();
        $this->mockCommandExecutor = new V2QueueCommandExecutor();
        $this->mockGitContext = GitContext::make(__DIR__);
    }

    protected function callMethodFromObject($object, string $method, ...$args)
    {
        $caller = function () use ($method, $args) {
            return $this->$method(...$args);
        };

        return $caller->call($object);
    }
}
