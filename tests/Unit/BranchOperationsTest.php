<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Exceptions\AlreadySwitched;
use ArtARTs36\GitHandler\Exceptions\BranchAlreadyExists;
use ArtARTs36\GitHandler\Exceptions\BranchNotFound;
use ArtARTs36\GitHandler\Exceptions\ObjectNameNotValid;
use ArtARTs36\GitHandler\Exceptions\ReferenceInvalid;
use ArtARTs36\GitHandler\Exceptions\UnexpectedException;

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
     * @covers \ArtARTs36\GitHandler\Git::deleteBranch
     */
    public function testDeleteBranchOnNullResult(): void
    {
        self::expectException(UnexpectedException::class);

        $this->mockGit(null)->deleteBranch('test');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::deleteBranch
     */
    public function testDeleteBranchOnOtherResult(): void
    {
        self::expectException(UnexpectedException::class);

        $this->mockGit('test')->deleteBranch('test');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::deleteBranch
     */
    public function testDeleteBranchOnBranchNotFound(): void
    {
        self::expectException(BranchNotFound::class);

        $this->mockGit("error: branch 'test' not found")->deleteBranch('test');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::newBranch
     */
    public function testNewBranchOnOtherResult(): void
    {
        self::expectException(UnexpectedException::class);

        $this->mockGit("error")->newBranch('test');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::newBranch
     */
    public function testNewBranchOnInvalidObjectName(): void
    {
        self::expectException(ObjectNameNotValid::class);

        $this->mockGit('fatal: Not a valid object name: \'1234\'')->newBranch('master');
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

    /**
     * @covers \ArtARTs36\GitHandler\Git::newBranch
     */
    public function testNewBranchOk(): void
    {
        $git = $this->mockGit(null);

        self::assertTrue($git->newBranch('test'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::newBranch
     */
    public function testNewBranchOnAlreadyExists(): void
    {
        self::expectException(BranchAlreadyExists::class);

        $this->mockGit("fatal: A branch named 'test' already exists")->newBranch('test');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::switchBranch
     */
    public function testSwitchBranchOnNullResult(): void
    {
        $git = $this->mockGit();

        self::expectException(UnexpectedException::class);

        $git->switchBranch('master');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::switchBranch
     */
    public function testSwitchBranchOnGood(): void
    {
        $git = $this->mockGit('Switched to branch \'master\'');

        self::assertTrue($git->switchBranch('master'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::switchBranch
     */
    public function testSwitchBranchOnInvalidReference(): void
    {
        $git = $this->mockGit('fatal: invalid reference: master');

        self::expectException(ReferenceInvalid::class);

        $git->switchBranch('master');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::switchBranch
     */
    public function testSwitchBranchOnAlreadySwitched(): void
    {
        $git = $this->mockGit('Already on \'master\'');

        self::expectException(AlreadySwitched::class);

        $git->switchBranch('master');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::switchBranch
     */
    public function testSwitchBranchOnUnexpectedReturnValue(): void
    {
        $git = $this->mockGit('random value');

        self::expectException(UnexpectedException::class);

        $git->switchBranch('master');
    }
}
