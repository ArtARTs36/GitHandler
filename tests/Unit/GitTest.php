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
     * @covers \ArtARTs36\GitHandler\Git::version
     */
    public function testVersion(): void
    {
        $this->mockCommandExecutor->addSuccess('git version 2.24.3 (Apple Git-128)');

        self::assertEquals([
            'full'  => 'git version 2.24.3 (Apple Git-128)',
            'major' => 2,
            'minor' => 24,
            'patch' => 3,
        ], $this->mockGitHandler->version()->toArray());
    }
}
