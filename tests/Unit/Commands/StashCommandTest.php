<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Commands;

use ArtARTs36\GitHandler\Command\Commands\StashCommand;
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
     * @covers \ArtARTs36\GitHandler\Command\Commands\StashCommand::stash
     */
    public function testStash(string $commandResult, bool $state): void
    {
        $this->mockCommandExecutor->addSuccess($commandResult);

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
     * @covers \ArtARTs36\GitHandler\Command\Commands\StashCommand::pop
     */
    public function testUnStash(string $commandResult, bool $state): void
    {
        $this->mockCommandExecutor->addSuccess($commandResult);

        self::assertEquals($state, $this->makeStashCommand()->pop());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\StashCommand::getList
     */
    public function testGetStashList(): void
    {
        $this->mockCommandExecutor->addSuccess('stash@{7}|WIP on 2.x: a561440 up artarts36/str');

        $result = $this->makeStashCommand()->getList();

        self::assertEquals([
            'id' => 7,
            'branch' => '2.x',
            'name' => 'a561440 up artarts36/str',
        ], $result[0]->toArray());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\StashCommand::apply
     */
    public function testApplyStashGood(): void
    {
        $this->mockCommandExecutor->addSuccess('Changes not staged for commit');

        self::assertTrue($this->makeStashCommand()->apply(1));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\StashCommand::apply
     */
    public function testApplyStashOnDoesNotExists(): void
    {
        $this->mockCommandExecutor->addFail("fatal: Log for 'stash' only has 5 entries");

        self::expectException(StashDoesNotExists::class);

        $this->makeStashCommand()->apply(1);
    }

    private function makeStashCommand(): StashCommand
    {
        return new StashCommand($this->mockCommandBuilder, $this->mockCommandExecutor);
    }
}
