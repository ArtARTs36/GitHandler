<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Exceptions\BranchNotFound;

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

    /**
     * @covers \ArtARTs36\GitHandler\Git::checkout
     */
    public function testCheckout(): void
    {
        $response = $this->mockGit("Already on 'master'")
            ->checkout('master');

        self::assertTrue($response);

        //

        self::expectException(BranchNotFound::class);

        $this->mockGit("pathspec 'random' did not match any")
            ->checkout('random', true);
    }
}
