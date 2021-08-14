<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Command\Groups\LogCommandGroup;
use ArtARTs36\GitHandler\Exceptions\BranchDoesNotHaveCommits;
use ArtARTs36\GitHandler\Logger;

class LogCommandGroupTest extends V2TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\LogCommandGroup::getAll
     */
    public function testLogOnBranchDoesNotHaveCommits(): void
    {
        $this->mockCommandExecutor->nextOk('fatal: your current branch \'master\' does not have any commits yet');

        $git = new LogCommandGroup(new Logger(), $this->mockCommandBuilder, $this->mockCommandExecutor);

        self::expectException(BranchDoesNotHaveCommits::class);

        $git->getAll();
    }
}
