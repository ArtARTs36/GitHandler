<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Command\Groups\LogCommand;
use ArtARTs36\GitHandler\Exceptions\BranchDoesNotHaveCommits;
use ArtARTs36\GitHandler\Logger;

class LogCommandTest extends V2TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\LogCommand::getAll
     */
    public function testLogOnBranchDoesNotHaveCommits(): void
    {
        $this->mockCommandExecutor->nextFailed('fatal: your current branch \'master\' does not have any commits yet');

        $git = new LogCommand(new Logger(), $this->mockCommandBuilder, $this->mockCommandExecutor);

        self::expectException(BranchDoesNotHaveCommits::class);

        $git->getAll();
    }
}
