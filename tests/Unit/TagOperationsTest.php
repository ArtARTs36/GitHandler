<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Exceptions\TagAlreadyExists;

class TagOperationsTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Git::getTags
     */
    public function testGetTags(): void
    {
        $git = $this->mockGit('0.1.0
0.2.0
0.2.1
');

        self::assertEquals([
            '0.1.0',
            '0.2.0',
            '0.2.1',
        ], $git->getTags('0.*'));

        //

        $git = $this->mockGit('');

        self::assertEquals([], $git->getTags());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::isTagExists
     * @covers \ArtARTs36\GitHandler\Git::getTags
     */
    public function testIsTagExistsOnFound(): void
    {
        self::assertTrue($this->mockGit('0.1.0')->isTagExists('0.1.0'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::isTagExists
     * @covers \ArtARTs36\GitHandler\Git::getTags
     */
    public function testIsTagExistsOnNotFound(): void
    {
        self::assertFalse($this->mockGit('0.2.0')->isTagExists('0.1.0'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::performTag
     */
    public function testPerformTagOnAlreadyExists(): void
    {
        self::expectException(TagAlreadyExists::class);

        $this
            ->mockGit(['1.0.0'])
            ->performTag('1.0.0');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::performTag
     */
    public function testPerformTag(): void
    {
        self::assertTrue($this->mockGit()->performTag('tag'));
    }
}
