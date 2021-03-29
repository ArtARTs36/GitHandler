<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Exceptions\BranchNotFound;
use ArtARTs36\GitHandler\Exceptions\FileNotFound;
use ArtARTs36\GitHandler\Exceptions\PathAlreadyExists;

final class GitTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Git::checkout
     */
    public function testCheckout(): void
    {
        $response = $this->mockGit("Already on 'master'")
            ->checkout('master');

        self::assertTrue($response);

        //

        self::expectException(BranchNotFound::class);

        $this->mockGit("pathspec 'random' did not match any")
            ->checkout('random');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::pull
     */
    public function testPull(): void
    {
        $git = $this->mockGit('Already up to date');

        self::assertTrue($git->pull());

        //

        $git = $this->mockGit("Receiving objects: 100% \n Resolving deltas: 100%");

        self::assertTrue($git->pull());

        //

        $git = $this->mockGit('');

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

        $git = $this->mockGit($shellResult);

        //

        self::assertEquals($expected, $git->status());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::add
     */
    public function testAdd(): void
    {
        $git = $this->mockGit('');

        self::assertTrue($git->add('README.MD'));

        //

        self::expectException(FileNotFound::class);

        $git = $this->mockGit("pathspec 'random.file' did not match any files");

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

        $git = $this->mockGit("Cloning into '{$folder}' ...", $dir);

        self::assertTrue($git->clone($url));

        //

        self::expectException(PathAlreadyExists::class);

        $this->mockGit("fatal: destination path '{$folder}' already exists " .
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

        $git = $this->mockGit("Cloning into '{$folder}' ...", $dir);

        self::assertTrue($git->clone($url, $branch));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::stash
     */
    public function testStash(): void
    {
        $git = $this->mockGit('');

        self::assertFalse($git->stash());

        //

        $git = $this->mockGit('Saved working directory and index state WIP on master: b68fd9d test');

        self::assertTrue($git->stash());

        //

        $git = $this->mockGit('No local changes to save');

        self::assertTrue($git->stash());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::showRemote
     */
    public function testShowRemote(): void
    {
        $git = $this->mockGit('* remote origin
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
     * @covers \ArtARTs36\GitHandler\Git::version
     */
    public function testVersion(): void
    {
        $git = $this->mockGit('git version 2.24.3 (Apple Git-128)
');

        self::assertEquals('git version 2.24.3 (Apple Git-128)', $git->version());
    }
}
