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

    /**
     * @covers \ArtARTs36\GitHandler\Git::getBranches
     */
    public function testGetBranches(): void
    {
        $git = $this->mockGit("  eee
* master
  repository-downloader
  remotes/origin/HEAD -> origin/master
  remotes/origin/config
");

        self::assertEquals([
            'eee',
            'master',
            'repository-downloader',
            'remotes/origin/HEAD -> origin/master',
            'remotes/origin/config',
        ], $git->getBranches());

        //

        $git = $this->mockGit('');

        self::assertEmpty($git->getBranches());
    }
}
