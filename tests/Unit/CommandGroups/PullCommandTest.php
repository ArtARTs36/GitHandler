<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Command\Groups\PullCommand;

class PullCommandTest extends V2TestCase
{
    public function providerForTestPull(): array
    {
        return [
            [
                'Already up to date',
                true,
            ],
            [
                "Receiving objects: 100% \n Resolving deltas: 100%",
                true,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestPull
     * @covers \ArtARTs36\GitHandler\Command\Groups\PullCommand::pull
     * @covers \ArtARTs36\GitHandler\Command\Groups\PullCommand::buildPurePullCommand
     */
    public function testPullOk(string $commandResult, bool $expectedState): void
    {
        $this->mockCommandExecutor->nextOk($commandResult);

        self::assertEquals($expectedState, $this->makePullCommand()->pull());
    }

    /**
     * @dataProvider providerForTestPull
     * @covers \ArtARTs36\GitHandler\Command\Groups\PullCommand::pull
     * @covers \ArtARTs36\GitHandler\Command\Groups\PullCommand::buildPurePullCommand
     */
    public function testPullBranchOk(string $commandResult, bool $expectedState): void
    {
        $this->mockCommandExecutor->nextOk($commandResult);

        self::assertEquals($expectedState, $this->makePullCommand()->pullBranch('master'));
    }

    private function makePullCommand(): PullCommand
    {
        return new PullCommand($this->mockCommandBuilder, $this->mockCommandExecutor);
    }
}
