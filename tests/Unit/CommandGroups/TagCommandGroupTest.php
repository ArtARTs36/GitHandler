<?php

namespace ArtARTs36\ShellCommand\Tests\Unit\CommandGroups;

use ArtARTs36\GitHandler\Command\Groups\TagCommandGroup;
use ArtARTs36\GitHandler\Exceptions\TagAlreadyExists;
use ArtARTs36\GitHandler\Exceptions\TagNotFound;
use ArtARTs36\GitHandler\Exceptions\UnexpectedException;
use ArtARTs36\GitHandler\Tests\Unit\V2TestCase;

class TagCommandGroupTest extends V2TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\TagCommandGroup
     */
    public function testGetTags(): void
    {
        $tags = $this->makeTagCommandGroup();

        $this->mockCommandExecutor->nextOk('0.1.0
0.2.0
0.2.1
');

        self::assertEquals([
            '0.1.0',
            '0.2.0',
            '0.2.1',
        ], $tags->getAll('0.*'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\TagCommandGroup::exists
     * @covers \ArtARTs36\GitHandler\Command\Groups\TagCommandGroup::getAll
     */
    public function testIsTagExistsOnFound(): void
    {
        $this->mockCommandExecutor->nextOk('0.1.0');

        self::assertTrue($this->makeTagCommandGroup()->exists('0.1.0'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\TagCommandGroup::exists
     * @covers \ArtARTs36\GitHandler\Command\Groups\TagCommandGroup::getAll
     */
    public function testIsTagExistsOnNotFound(): void
    {
        $this->mockCommandExecutor->nextOk();

        self::assertFalse($this->makeTagCommandGroup()->exists('0.1.0'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\TagCommandGroup::add
     */
    public function testAddTagOnAlreadyExists(): void
    {
        self::expectException(TagAlreadyExists::class);

        $this->mockCommandExecutor->nextOk('1.0.0');

        $this->makeTagCommandGroup()->add('1.0.0');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\TagCommandGroup::add
     */
    public function testAddTag(): void
    {
        $this->mockCommandExecutor->nextOk()->nextOk();

        self::assertTrue($this->makeTagCommandGroup()->add('0.1.0'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\TagCommandGroup::add
     */
    public function testGetTagFound(): void
    {
        $this->mockCommandExecutor->nextOk(
            'ArtARTs36|temicska99@mail.ru|Mon, 26 Jul 2021 22:47:34 +0300|'.
            '3e60b7250a3fdaebd50edca9bbe8a1aea7f40410|fix Git::add at many files'
        );

        $git = $this->makeTagCommandGroup();

        $tag = $git->get('0.12.1');

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
     * @covers \ArtARTs36\GitHandler\Command\Groups\TagCommandGroup::get
     */
    public function testGetTagOnUnexpectedException(): void
    {
        $this->mockCommandExecutor->nextFailed();

        self::expectException(UnexpectedException::class);

        $tags = $this->makeTagCommandGroup();

        $tags->get(1);
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\TagCommandGroup::get
     */
    public function testGetTagOnUnexpectedExceptionWithNull(): void
    {
        $this->mockCommandExecutor->nextFailed();

        self::expectException(UnexpectedException::class);

        $this->makeTagCommandGroup()->get(1);
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\TagCommandGroup::get
     */
    public function testGetTagOnNotFound(): void
    {
        self::expectException(TagNotFound::class);

        $this
            ->mockCommandExecutor
            ->nextFailed("ambiguous argument '111': unknown revision or path not in the working tree");

        $git = $this->makeTagCommandGroup();

        $git->get('111');
    }

    protected function makeTagCommandGroup(): TagCommandGroup
    {
        return new TagCommandGroup($this->mockCommandBuilder, $this->mockCommandExecutor);
    }
}
