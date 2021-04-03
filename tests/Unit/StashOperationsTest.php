<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

class StashOperationsTest extends TestCase
{
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

        //

        $git = $this->mockGit('Saved working directory and index state WIP on master: b68fd9d test');

        self::assertTrue($git->stash('message'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::unStash
     */
    public function testUnStash(): void
    {
        $git = $this->mockGit('Changes not staged for commit:');

        self::assertTrue($git->unStash());

        //

        $git = $this->mockGit('');

        self::assertFalse($git->unStash());
    }
}
