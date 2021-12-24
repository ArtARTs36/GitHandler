<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Commands;

use ArtARTs36\GitHandler\Command\Commands\IndexCommand;
use ArtARTs36\GitHandler\Command\Commands\CommitCommand;
use ArtARTs36\GitHandler\Command\Commands\StatusCommand;
use ArtARTs36\GitHandler\Exceptions\NothingToCommit;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;

final class CommitCommandTest extends GitTestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\CommitCommand::commit
     */
    public function testCommitOnNothingToCommit(): void
    {
        self::expectException(NothingToCommit::class);

        $this->mockCommandExecutor->addFail('nothing to commit');

        $this->makeCommitCommand()->commit('');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\CommitCommand::commit
     */
    public function testCommitOnFileChanged(): void
    {
        $this->mockCommandExecutor->addSuccess('file changed');

        self::assertTrue($this->makeCommitCommand()->commit('', true));
    }

    private function makeCommitCommand(): CommitCommand
    {
        return new CommitCommand(
            new IndexCommand($this->mockCommandBuilder, $this->mockCommandExecutor),
            new StatusCommand($this->mockCommandBuilder, $this->mockCommandExecutor),
            $this->mockCommandBuilder,
            $this->mockCommandExecutor
        );
    }
}
