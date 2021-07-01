<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Contracts\LogParser;
use ArtARTs36\GitHandler\Data\LogCollection;
use ArtARTs36\GitHandler\Exceptions\BranchDoesNotHaveCommits;
use ArtARTs36\GitHandler\Exceptions\UnexpectedException;
use ArtARTs36\GitHandler\Logger;
use ArtARTs36\Str\Str;

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
    public function testLogEmpty(): void
    {
        $git = $this->mockGit(
            'text text text˚',
            null,
            new class implements LogParser {
                public function parse(Str $raw): ?LogCollection
                {
                    return null;
                }
            }
        );

        self::assertNull($git->log());
    }
}
