<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Commands;

use ArtARTs36\GitHandler\Command\Commands\LogCommand;
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
        $this->mockCommandExecutor->nextFailed('fatal: your current branch \'master\' does not have any commits yet');

        $git = $this->makeLogCommand();

        self::expectException(BranchDoesNotHaveCommits::class);

        $git->getAll();
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\LogCommand::logForFile
     * @covers \ArtARTs36\GitHandler\Command\Commands\LogCommand::__construct
     * @covers \ArtARTs36\GitHandler\Command\Commands\LogCommand::buildLogCommand
     * @covers \ArtARTs36\GitHandler\Command\Commands\LogCommand::executeAndParseLogCommand
     */
    public function testLogForFileOnBranchDoesNotHaveCommits(): void
    {
        $this->mockCommandExecutor->nextFailed('fatal: your current branch \'master\' does not have any commits yet');

        $git = $this->makeLogCommand();

        self::expectException(BranchDoesNotHaveCommits::class);

        $git->logForFile('file.txt');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\LogCommand::logForFileOnLines
     * @covers \ArtARTs36\GitHandler\Command\Commands\LogCommand::__construct
     * @covers \ArtARTs36\GitHandler\Command\Commands\LogCommand::buildLogCommand
     * @covers \ArtARTs36\GitHandler\Command\Commands\LogCommand::executeAndParseLogCommand
     */
    public function testLogForFileOnFilesOnBranchDoesNotHaveCommits(): void
    {
        $this->mockCommandExecutor->nextFailed('fatal: your current branch \'master\' does not have any commits yet');

        $git = $this->makeLogCommand();

        self::expectException(BranchDoesNotHaveCommits::class);

        $git->logForFileOnLines('file.txt', 1, 2);
    }

    private function makeLogCommand(): LogCommand
    {
        return new LogCommand(new Logger(), $this->mockCommandBuilder, $this->mockCommandExecutor);
    }
}
