<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Commands;

use ArtARTs36\GitHandler\Command\Groups\StashCommand;
use ArtARTs36\GitHandler\Exceptions\StashDoesNotExists;
use ArtARTs36\GitHandler\Exceptions\UnexpectedException;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;

final class StashCommandTest extends GitTestCase
{
    public function providerForTestStash(): array
    {
        return [
            [
                '',
                false,
            ],
            [
                'Saved working directory and index state WIP on master: b68fd9d test',
                true,
            ],
            [
                'No local changes to save',
                true,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestStash
     * @covers \ArtARTs36\GitHandler\Command\Groups\StashCommand::stash
     */
    public function testStash(string $commandResult, bool $state): void
    {
        $this->mockCommandExecutor->nextOk($commandResult);

        self::assertEquals($state, $this->makeStashCommand()->stash('message'));
    }

    public function providerForTestUnStash(): array
    {
        return [
            [
                'Changes not staged for commit:',
                true,
            ],
            [
                '',
                false,
            ]
        ];
    }

    /**
     * @dataProvider providerForTestUnStash
     * @covers \ArtARTs36\GitHandler\Command\Groups\StashCommand::pop
     */
    public function testUnStash(string $commandResult, bool $state): void
    {
        $this->mockCommandExecutor->nextOk($commandResult);

        self::assertEquals($state, $this->makeStashCommand()->pop());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\StashCommand::getStashList
     */
    public function testGetStashList(): void
    {
        $this->mockCommandExecutor->nextOk('stash@{7}|WIP on 2.x: a561440 up artarts36/str');

        $result = $this->makeStashCommand()->getStashList();

        self::assertEquals([
            'id' => 7,
            'branch' => '2.x',
            'name' => 'a561440 up artarts36/str',
        ], $result[0]->toArray());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\StashCommand::applyStash
     */
    public function testApplyStashGood(): void
    {
        $this->mockCommandExecutor->nextOk('Changes not staged for commit');

        self::assertTrue($this->makeStashCommand()->applyStash(1));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\StashCommand::applyStash
     */
    public function testApplyStashOnDoesNotExists(): void
    {
        $this->mockCommandExecutor->nextFailed("fatal: Log for 'stash' only has 5 entries");

        self::expectException(StashDoesNotExists::class);

        $this->makeStashCommand()->applyStash(1);
    }

    private function makeStashCommand(): StashCommand
    {
        return new StashCommand($this->mockCommandBuilder, $this->mockCommandExecutor);
    }
}
