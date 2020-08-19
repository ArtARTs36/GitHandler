<?php

namespace ArtARTs36\HostReviewerCore\Tests\Unit;

use ArtARTs36\GitHandler\Exceptions\BranchNotFound;
use ArtARTs36\GitHandler\Exceptions\FileNotFound;
use ArtARTs36\GitHandler\Git;
use ArtARTs36\ShellCommand\ShellCommand;
use PHPUnit\Framework\TestCase;

final class GitTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Git::init
     */
    public function testInit(): void
    {
        $response = $this->mock('error')
            ->init();

        self::assertFalse($response);

        //

        $response = $this->mock('Initialized empty Git repository in ')
            ->init();

        self::assertTrue($response);
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::checkout
     */
    public function testCheckout(): void
    {
        $response = $this->mock("Already on 'master'")
            ->checkout('master');

        self::assertTrue($response);

        //

        self::expectException(BranchNotFound::class);

        $this->mock("pathspec 'random' did not match any")
            ->checkout('random');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::pull
     */
    public function testPull(): void
    {
        $git = $this->mock('Already up to date');

        self::assertTrue($git->pull());

        //

        $git = $this->mock("Receiving objects: 100% \n Resolving deltas: 100%");

        self::assertTrue($git->pull());

        //

        $git = $this->mock('');

        self::assertFalse($git->pull());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::status
     */
    public function testStatus(): void
    {
        $expected = $shellResult = 'On branch master

No commits yet

Changes to be committed:
';

        $git = $this->mock($shellResult);

        //

        self::assertEquals($expected, $git->status());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::add
     */
    public function testAdd(): void
    {
        $git = $this->mock('');

        self::assertTrue($git->add('README.MD'));

        //

        self::expectException(FileNotFound::class);

        $git = $this->mock("pathspec 'random.file' did not match any files");

        $git->add('random.file');
    }

    /**
     * @param string $shellResult
     * @return Git
     */
    protected function mock(string $shellResult): Git
    {
        return new class(__DIR__ . '/../../', $shellResult, 'git') extends Git {
            private $shellResult;

            public function __construct(string $dir, string $shellResult, string $executor = 'git')
            {
                parent::__construct($dir, $executor);

                $this->shellResult = $shellResult;
            }

            protected function executeCommand(ShellCommand $command)
            {
                return $this->shellResult;
            }
        };
    }
}
