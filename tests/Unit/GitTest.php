<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Exceptions\BranchNotFound;
use ArtARTs36\GitHandler\Exceptions\FileNotFound;
use ArtARTs36\GitHandler\Exceptions\NothingToCommit;
use ArtARTs36\GitHandler\Exceptions\PathAlreadyExists;
use ArtARTs36\GitHandler\Exceptions\UnexpectedException;

final class GitTest extends TestCase
{
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

        $git = $this->mockGit("Receiving objects: 100% \n Resolving deltas: 100%");

        self::assertTrue($git->pull('master'));

        //

        self::expectException(UnexpectedException::class);

        $this->mockGit('')->pull();
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::status
     */
    public function testStatus(): void
    {
        $expected = $shellResult = 'On branch master

No commits yet

Changes to be committed:';

        $git = $this->mockGit($shellResult);

        //

        self::assertEquals($expected, (string) $git->status());
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
    public function testCloneUndefinedError(): void
    {
        $git = $this->mockGit(null);

        self::expectException(UnexpectedException::class);

        $git->clone('');
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
     * @covers \ArtARTs36\GitHandler\Git::version
     */
    public function testVersion(): void
    {
        $git = $this->mockGit('git version 2.24.3 (Apple Git-128)
');

        self::assertEquals('git version 2.24.3 (Apple Git-128)', $git->version());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::getDir
     */
    public function testGetDir(): void
    {
        $git = $this->mockGit('', $dir = '/path/to/dir');

        self::assertEquals($dir, $git->getDir());
    }
}
