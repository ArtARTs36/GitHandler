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
