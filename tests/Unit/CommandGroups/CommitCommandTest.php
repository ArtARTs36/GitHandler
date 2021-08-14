<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Command\Groups\AddCommand;
use ArtARTs36\GitHandler\Command\Groups\CommitCommand;
use ArtARTs36\GitHandler\Command\Groups\StatusCommand;
use ArtARTs36\GitHandler\Exceptions\NothingToCommit;

final class CommitCommandTest extends V2TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\CommitCommand::commit
     */
    public function testCommitOnNothingToCommit(): void
    {
        self::expectException(NothingToCommit::class);

        $this->mockCommandExecutor->nextFailed('nothing to commit');

        $this->makeCommitCommand()->commit('');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\CommitCommand::commit
     */
    public function testCommitOnFileChanged(): void
    {
        $this->mockCommandExecutor->nextOk('file changed');

        self::assertTrue($this->makeCommitCommand()->commit('', true));
    }

    protected function makeCommitCommand(): CommitCommand
    {
        return new CommitCommand(
            new AddCommand($this->mockCommandBuilder, $this->mockCommandExecutor),
            new StatusCommand($this->mockCommandBuilder, $this->mockCommandExecutor),
            $this->mockCommandBuilder,
            $this->mockCommandExecutor
        );
    }
}
