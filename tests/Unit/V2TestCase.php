<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Command\GitCommandBuilder;
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

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockCommandBuilder = new GitCommandBuilder(new ShellCommander(), 'git', __DIR__);
        $this->mockFileSystem = new ArrayFileSystem();
        $this->mockCommandExecutor = new V2QueueCommandExecutor();
    }
}