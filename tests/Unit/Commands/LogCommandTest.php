<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Commands;

use ArtARTs36\GitHandler\Command\Commands\LogCommand;
use ArtARTs36\GitHandler\Data\Author\Hydrator;
use ArtARTs36\GitHandler\Exceptions\BranchDoesNotHaveCommits;
use ArtARTs36\GitHandler\Support\Logger;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;

final class LogCommandTest extends GitTestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\LogCommand::getAll
     * @covers \ArtARTs36\GitHandler\Command\Commands\LogCommand::__construct
     * @covers \ArtARTs36\GitHandler\Command\Commands\LogCommand::buildLogCommand
     * @covers \ArtARTs36\GitHandler\Command\Commands\LogCommand::executeAndParseLogCommand
     */
    public function testLogOnBranchDoesNotHaveCommits(): void
    {
        $this->mockCommandExecutor->addFail('fatal: your current branch \'master\' does not have any commits yet');

        $git = new LogCommand(new Logger(new Hydrator()), $this->mockCommandBuilder, $this->mockCommandExecutor);

        self::expectException(BranchDoesNotHaveCommits::class);

        $git->getAll();
    }
}
