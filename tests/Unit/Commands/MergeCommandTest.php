<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Commands;

use ArtARTs36\GitHandler\Command\Commands\MergeCommand;
use ArtARTs36\GitHandler\Exceptions\MergeHeadMissing;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;

final class MergeCommandTest extends GitTestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\MergeCommand::abort
     */
    public function testAbortOnMergeHeadMissing(): void
    {
        $command = $this->makeMergeCommand();

        $this->mockCommandExecutor->nextFailed('fatal: There is no merge to abort (MERGE_HEAD missing)');

        self::expectException(MergeHeadMissing::class);

        $command->abort();
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\MergeCommand::abort
     */
    public function testAbortOk(): void
    {
        $this->mockCommandExecutor->nextOk();

        self::assertNull($this->makeMergeCommand()->abort());
    }

    private function makeMergeCommand(): MergeCommand
    {
        return new MergeCommand(
            $this->mockCommandBuilder,
            $this->mockCommandExecutor
        );
    }
}
