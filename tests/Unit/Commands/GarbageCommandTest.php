<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Commands;

use ArtARTs36\GitHandler\Command\Commands\GarbageCommand;
use ArtARTs36\GitHandler\Enum\GarbageCollectMode;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;

final class GarbageCommandTest extends GitTestCase
{
    public function commonProviderForTestsCollect(): array
    {
        return [
            [
                'Nothing new to pack.',
                GarbageCollectMode::AUTO,
                false,
            ],
            [
                '',
                GarbageCollectMode::AUTO,
                true,
            ],
        ];
    }

    /**
     * @dataProvider commonProviderForTestsCollect
     * @covers \ArtARTs36\GitHandler\Command\Commands\GarbageCommand::collect
     * @covers \ArtARTs36\GitHandler\Command\Commands\GarbageCommand::buildPureCommand
     * @covers \ArtARTs36\GitHandler\Command\Commands\GarbageCommand::analyzeCollectAnswer
     */
    public function testCollect(string $commandResult, string $mode, bool $expected): void
    {
        $command = $this->makeGarbageCommand();

        $this->mockCommandExecutor->nextOk($commandResult);

        self::assertEquals($expected, $command->collect(GarbageCollectMode::from($mode)));
    }

    /**
     * @dataProvider commonProviderForTestsCollect
     * @covers \ArtARTs36\GitHandler\Command\Commands\GarbageCommand::collectOnDate
     * @covers \ArtARTs36\GitHandler\Command\Commands\GarbageCommand::buildPureCommand
     * @covers \ArtARTs36\GitHandler\Command\Commands\GarbageCommand::analyzeCollectAnswer
     */
    public function testCollectOnDate(string $commandResult, string $mode, bool $expected): void
    {
        $command = $this->makeGarbageCommand();

        $this->mockCommandExecutor->nextOk($commandResult);

        self::assertEquals($expected, $command->collectOnDate(GarbageCollectMode::from($mode), new \DateTime()));
    }

    private function makeGarbageCommand(): GarbageCommand
    {
        return new GarbageCommand($this->mockCommandBuilder, $this->mockCommandExecutor);
    }
}
