<?php

namespace ArtARTs36\ShellCommand\Tests\Unit\CommandGroups;

use ArtARTs36\GitHandler\Command\Commands\TagCommand;
use ArtARTs36\GitHandler\Exceptions\TagAlreadyExists;
use ArtARTs36\GitHandler\Exceptions\TagNotFound;
use ArtARTs36\GitHandler\Exceptions\UnexpectedException;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;

final class TagCommandTest extends GitTestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\TagCommand::getAll
     */
    public function testGetAll(): void
    {
        $tags = $this->makeTagCommand();

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
     * @covers \ArtARTs36\GitHandler\Command\Commands\TagCommand::exists
     * @covers \ArtARTs36\GitHandler\Command\Commands\TagCommand::getAll
     */
    public function testIsTagExistsOnFound(): void
    {
        $this->mockCommandExecutor->nextOk('0.1.0');

        self::assertTrue($this->makeTagCommand()->exists('0.1.0'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\TagCommand::exists
     * @covers \ArtARTs36\GitHandler\Command\Commands\TagCommand::getAll
     */
    public function testIsTagExistsOnNotFound(): void
    {
        $this->mockCommandExecutor->nextOk();

        self::assertFalse($this->makeTagCommand()->exists('0.1.0'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\TagCommand::add
     */
    public function testAddTagOnAlreadyExists(): void
    {
        self::expectException(TagAlreadyExists::class);

        $this->mockCommandExecutor->nextOk('1.0.0');

        $this->makeTagCommand()->add('1.0.0');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\TagCommand::add
     */
    public function testAddTag(): void
    {
        $this->mockCommandExecutor->nextOk()->nextOk();

        self::assertTrue($this->makeTagCommand()->add('0.1.0'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\TagCommand::get
     */
    public function testGetTagFound(): void
    {
        $this->mockCommandExecutor->nextOk(
            'ArtARTs36|temicska99@mail.ru|Mon, 26 Jul 2021 22:47:34 +0300|'.
            '3e60b7250a3fdaebd50edca9bbe8a1aea7f40410|fix Git::add at many files'
        );

        $git = $this->makeTagCommand();

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
     * @covers \ArtARTs36\GitHandler\Command\Commands\TagCommand::get
     */
    public function testGetTagOnUnexpectedExceptionWithNull(): void
    {
        $this->mockCommandExecutor->nextOk('invalid structure answer');

        self::expectException(UnexpectedException::class);

        $this->makeTagCommand()->get(1);
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\TagCommand::get
     */
    public function testGetTagOnNotFound(): void
    {
        self::expectException(TagNotFound::class);

        $this
            ->mockCommandExecutor
            ->nextFailed("ambiguous argument '111': unknown revision or path not in the working tree");

        $git = $this->makeTagCommand();

        $git->get('111');
    }

    private function makeTagCommand(): TagCommand
    {
        return new TagCommand($this->mockCommandBuilder, $this->mockCommandExecutor);
    }
}
