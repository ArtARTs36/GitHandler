<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Exceptions\StashDoesNotExists;
use ArtARTs36\GitHandler\Exceptions\UnexpectedException;

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

    /**
     * @covers \ArtARTs36\GitHandler\Git::getStashList
     */
    public function testGetStashListOnNullResult(): void
    {
        self::assertSame([], $this->mockGit()->getStashList());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::getStashList
     */
    public function testGetStashList(): void
    {
        $result = $this->mockGit('stash@{7}|WIP on 2.x: a561440 up artarts36/str')->getStashList();

        self::assertEquals([
            'id' => 7,
            'branch' => '2.x',
            'name' => 'a561440 up artarts36/str',
        ], $result[0]->toArray());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::applyStash
     */
    public function testApplyStashOnNullResult(): void
    {
        self::expectException(UnexpectedException::class);

        $this->mockGit()->applyStash(1);
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::applyStash
     */
    public function testApplyStashGood(): void
    {
        self::assertTrue($this->mockGit('Changes not staged for commit')->applyStash(1));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::applyStash
     */
    public function testApplyStashOnDoesNotExists(): void
    {
        self::expectException(StashDoesNotExists::class);

        $this->mockGit("fatal: Log for 'stash' only has 5 entries")->applyStash(1);
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::applyStash
     */
    public function testApplyStashOnUnexpectedResult(): void
    {
        self::expectException(UnexpectedException::class);

        $this->mockGit('test')->applyStash(1);
    }
}
