<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Exceptions\BranchNotFound;
use ArtARTs36\GitHandler\Exceptions\FileNotFound;
use ArtARTs36\GitHandler\Exceptions\NothingToCommit;
use ArtARTs36\GitHandler\Exceptions\PathAlreadyExists;
use ArtARTs36\GitHandler\Exceptions\UnexpectedException;

final class GitTest extends GitTestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Git::delete
     */
    public function testDelete(): void
    {
        $this->mockFileSystem->createDir($this->mockGitContext->getRootDir());

        $this->mockGitHandler->delete();

        self::assertFalse($this->mockFileSystem->exists($this->mockGitContext->getRootDir()));
    }
}
