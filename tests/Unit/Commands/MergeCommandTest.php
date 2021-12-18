<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Commands;

use ArtARTs36\GitHandler\Command\Commands\MergeCommand;
use ArtARTs36\GitHandler\Exceptions\MergeHeadMissing;
use ArtARTs36\GitHandler\Exceptions\NotSomethingWeCanMerge;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;

final class MergeCommandTest extends GitTestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\MergeCommand::abort
     */
    public function testAbortOnMergeHeadMissing(): void
    {
        $command = $this->makeMergeCommand();

        $this->mockCommandExecutor->addFail('fatal: There is no merge to abort (MERGE_HEAD missing)');

        self::expectException(MergeHeadMissing::class);

        $command->abort();
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\MergeCommand::abort
     */
    public function testAbortOk(): void
    {
        $this->mockCommandExecutor->addSuccess();

        self::assertNull($this->makeMergeCommand()->abort());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\MergeCommand::merge
     * @covers \ArtARTs36\GitHandler\Command\Commands\MergeCommand::buildMergeCommand
     */
    public function testMergeOnNotSomethingWeCanMerge(): void
    {
        $command = $this->makeMergeCommand();

        $this->mockCommandExecutor->addFail('merge: branch1 - not something we can merge#');

        self::expectException(NotSomethingWeCanMerge::class);

        $command->merge('branch1', 'test-message');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\MergeCommand::mergeSquash
     * @covers \ArtARTs36\GitHandler\Command\Commands\MergeCommand::buildMergeCommand
     */
    public function testMergeSquashOnNotSomethingWeCanMerge(): void
    {
        $command = $this->makeMergeCommand();

        $this->mockCommandExecutor->addFail('merge: branch1 - not something we can merge#');

        self::expectException(NotSomethingWeCanMerge::class);

        $command->mergeSquash('branch1');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\MergeCommand::merge
     */
    public function testMergeOk(): void
    {
        $this->mockCommandExecutor->addSuccess();

        self::assertNull($this->makeMergeCommand()->merge('branch1'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\MergeCommand::mergeSquash
     */
    public function testMergeSquashOk(): void
    {
        $this->mockCommandExecutor->addSuccess();

        self::assertNull($this->makeMergeCommand()->mergeSquash('branch1'));
    }

    private function makeMergeCommand(): MergeCommand
    {
        return new MergeCommand(
            $this->mockCommandBuilder,
            $this->mockCommandExecutor
        );
    }
}
