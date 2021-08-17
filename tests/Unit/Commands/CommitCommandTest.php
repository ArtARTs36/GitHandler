<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Commands;

use ArtARTs36\GitHandler\Command\Groups\IndexCommand;
use ArtARTs36\GitHandler\Command\Groups\CommitCommand;
use ArtARTs36\GitHandler\Command\Groups\StatusCommand;
use ArtARTs36\GitHandler\Exceptions\NothingToCommit;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;

final class CommitCommandTest extends GitTestCase
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
            new IndexCommand($this->mockCommandBuilder, $this->mockCommandExecutor),
            new StatusCommand($this->mockCommandBuilder, $this->mockCommandExecutor),
            $this->mockCommandBuilder,
            $this->mockCommandExecutor
        );
    }
}
