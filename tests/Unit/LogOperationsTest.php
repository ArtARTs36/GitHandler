<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Exceptions\BranchDoesNotHaveCommits;
use ArtARTs36\GitHandler\Exceptions\UnexpectedException;

class LogOperationsTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Git::log
     */
    public function testLogOnUndefinedException(): void
    {
        $git = $this->mockGit(null);

        self::expectException(UnexpectedException::class);

        $git->log();
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::log
     */
    public function testLogOnBranchDoesNotHaveCommits(): void
    {
        $git = $this->mockGit('fatal: your current branch \'master\' does not have any commits yet');

        self::expectException(BranchDoesNotHaveCommits::class);

        $git->log();
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::log
     */
    public function testLogGood(): void
    {
        $git = $this->mockGit('fatal: your current branch \'master\' does not have any commits yet');

        self::expectException(BranchDoesNotHaveCommits::class);

        $git->log();
    }
}
