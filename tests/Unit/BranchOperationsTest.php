<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

class BranchOperationsTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Git::deleteBranch
     */
    public function testDeleteBranch(): void
    {
        $git = $this->mockGit('Deleted branch config (was a48b10d).');

        self::assertTrue($git->deleteBranch('config'));
    }
}
