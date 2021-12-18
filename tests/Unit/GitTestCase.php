<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Command\GitCommandBuilder;
use ArtARTs36\GitHandler\Data\GitContext;
use ArtARTs36\GitHandler\Git;
use ArtARTs36\GitHandler\Tests\Support\ArrayFileSystem;
use ArtARTs36\ShellCommand\Executors\TestExecutor;
use ArtARTs36\ShellCommand\ShellCommander;

abstract class GitTestCase extends TestCase
{
    /** @var GitCommandBuilder */
    protected $mockCommandBuilder;

    /** @var ArrayFileSystem */
    protected $mockFileSystem;

    /** @var TestExecutor */
    protected $mockCommandExecutor;

    /** @var GitContext */
    protected $mockGitContext;

    /** @var Git */
    protected $mockGitHandler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockCommandBuilder = new GitCommandBuilder(new ShellCommander(), 'git', __DIR__);
        $this->mockFileSystem = new ArrayFileSystem();
        $this->mockCommandExecutor = new TestExecutor();
        $this->mockGitContext = GitContext::make(__DIR__);
        $this->mockGitHandler = new Git(
            $this->mockCommandBuilder,
            $this->mockCommandExecutor,
            $this->mockFileSystem,
            $this->mockGitContext
        );
    }
}
