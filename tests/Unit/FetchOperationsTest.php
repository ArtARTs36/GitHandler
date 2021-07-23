<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

class FetchOperationsTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Git::fetch
     * @covers \ArtARTs36\GitHandler\Git::buildFetchCommand
     */
    public function testFetchGood(): void
    {
        $git = $this->mockGit();

        self::assertNull($git->fetch());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::fetchAll
     * @covers \ArtARTs36\GitHandler\Git::buildFetchCommand
     */
    public function testFetchAllGood(): void
    {
        $git = $this->mockGit();

        self::assertNull($git->fetchAll());
    }
}
