<?php

namespace ArtARTs36\GitHandler\Tests;

use ArtARTs36\GitHandler\Exceptions\BranchNotFound;
use ArtARTs36\GitHandler\Exceptions\FileNotFound;
use ArtARTs36\GitHandler\Exceptions\PathAlreadyExists;
use ArtARTs36\GitHandler\Git;
use ArtARTs36\GitHandler\GitSimpleFactory;
use ArtARTs36\GitHandler\Logger;
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
     * @covers \ArtARTs36\GitHandler\Git::clone
     */
    public function testClone(): void
    {
        $folder = 'project';
        $dir = '/var/web/'. $folder;
        $url = 'http://url.git';

        //

        $git = $this->mock("Cloning into '{$folder}' ...", $dir);

        self::assertTrue($git->clone($url));

        //

        self::expectException(PathAlreadyExists::class);

        $this->mock("fatal: destination path '{$folder}' already exists " .
            "and is not an empty directory.", $dir)->clone($url);
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::clone
     */
    public function testCloneBranch(): void
    {
        $folder = 'project';
        $dir = '/var/web/'. $folder;
        $url = 'http://url.git';
        $branch = 'dev';

        $git = $this->mock("Cloning into '{$folder}' ...", $dir);

        self::assertTrue($git->clone($url, $branch));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::stash
     */
    public function testStash(): void
    {
        $git = $this->mock('');

        self::assertFalse($git->stash());

        //

        $git = $this->mock('Saved working directory and index state WIP on master: b68fd9d test');

        self::assertTrue($git->stash());

        //

        $git = $this->mock('No local changes to save');

        self::assertTrue($git->stash());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::showRemote
     */
    public function testShowRemote(): void
    {
        $git = $this->mock('* remote origin
  Fetch URL: https://github.com/ArtARTs36/GitHandler.git
  Push  URL: https://github.com/ArtARTs36/GitHandler.git
  HEAD branch: master
  Remote branch:
    master tracked
  Local branch configured for \'git pull\':
    master merges with remote master
  Local ref configured for \'git push\':
    master pushes to master (up to date)
');

        $expected = [
            'fetch' => 'https://github.com/ArtARTs36/GitHandler.git',
            'push' => 'https://github.com/ArtARTs36/GitHandler.git',
        ];

        self::assertEquals($expected, $git->showRemote()->toArray());
    }

    /**
     * @param string $shellResult
     * @param string|null $dir
     * @return Git
     */
    protected function mock(string $shellResult, string $dir = null): Git
    {
        $dir = $dir ?? __DIR__ . '/../../';

        return new class($dir, $shellResult, 'git') extends Git {
            private $shellResult;

            public function __construct(string $dir, string $shellResult, string $executor = 'git')
            {
                parent::__construct($dir, new Logger(), GitSimpleFactory::factoryConfigReader(), $executor);

                $this->shellResult = $shellResult;
            }

            protected function executeCommand(ShellCommand $command): ?string
            {
                return $this->shellResult;
            }
        };
    }
}
