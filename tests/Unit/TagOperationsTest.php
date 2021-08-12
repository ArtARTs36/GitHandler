<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Exceptions\TagAlreadyExists;
use ArtARTs36\GitHandler\Exceptions\TagNotFound;
use ArtARTs36\GitHandler\Exceptions\UnexpectedException;

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

    /**
     * @covers \ArtARTs36\GitHandler\Git::getTag
     */
    public function testGetTagFound(): void
    {
        $git = $this->mockGit(
            'ArtARTs36|temicska99@mail.ru|Mon, 26 Jul 2021 22:47:34 +0300|'.
            '3e60b7250a3fdaebd50edca9bbe8a1aea7f40410|fix Git::add at many files'
        );

        $tag = $git->getTag('0.12.1');

        self::assertEquals([
            'name' => 'ArtARTs36',
            'email' => 'temicska99@mail.ru',
            'commit' => '3e60b7250a3fdaebd50edca9bbe8a1aea7f40410',
            'message' => 'fix Git::add at many files',
        ], [
            'name' => $tag->author->name,
            'email' => $tag->author->email,
            'commit' => $tag->commit->hash,
            'message' => $tag->message,
        ]);
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::getTag
     */
    public function testGetTagOnUnexpectedException(): void
    {
        self::expectException(UnexpectedException::class);

        $this->mockGit('')->getTag(1);
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::getTag
     */
    public function testGetTagOnUnexpectedExceptionWithNull(): void
    {
        self::expectException(UnexpectedException::class);

        $this->mockGit()->getTag(1);
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::getTag
     */
    public function testGetTagOnNotFound(): void
    {
        self::expectException(TagNotFound::class);

        $git = $this->mockGit("ambiguous argument '111': unknown revision or path not in the working tree");

        $git->getTag('111');
    }
}
