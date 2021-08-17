<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Commands;

use ArtARTs36\GitHandler\Command\Groups\BranchCommand;
use ArtARTs36\GitHandler\Exceptions\AlreadySwitched;
use ArtARTs36\GitHandler\Exceptions\BranchAlreadyExists;
use ArtARTs36\GitHandler\Exceptions\BranchNotFound;
use ArtARTs36\GitHandler\Exceptions\ObjectNameNotValid;
use ArtARTs36\GitHandler\Exceptions\ReferenceInvalid;
use ArtARTs36\GitHandler\Tests\Unit\V2TestCase;

final class BranchCommandTest extends V2TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\BranchCommand::delete
     */
    public function testDeleteOk(): void
    {
        $this->mockCommandExecutor->nextOk('Deleted branch config (was a48b10d).');

        self::assertTrue($this->makeBranchCommand()->delete('config'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\BranchCommand::delete
     */
    public function testDeleteBranchOnBranchNotFound(): void
    {
        self::expectException(BranchNotFound::class);

        $this->mockCommandExecutor->nextFailed("error: branch 'test' not found");

        $this->makeBranchCommand()->delete('test');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\BranchCommand::newBranch
     */
    public function testNewBranchOnInvalidObjectName(): void
    {
        self::expectException(ObjectNameNotValid::class);

        $this->mockCommandExecutor->nextFailed('fatal: Not a valid object name: \'1234\'');

        $this->makeBranchCommand()->newBranch('master');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\BranchCommand::getBranches
     */
    public function testGetAll(): void
    {
        $this->mockCommandExecutor->nextOk("  eee
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
        ], $this->makeBranchCommand()->getBranches());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\BranchCommand::checkout
     */
    public function testCheckoutOk(): void
    {
        $this->mockCommandExecutor->nextOk("Already on 'master'");

        self::assertTrue($this->makeBranchCommand()->checkout('master', true));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\BranchCommand::checkout
     */
    public function testCheckoutOnNotFoundBranch(): void
    {
        self::expectException(BranchNotFound::class);

        $this->mockCommandExecutor->nextFailed("pathspec 'random' did not match any");

        $this->makeBranchCommand()->checkout('random');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\BranchCommand::newBranch
     */
    public function testNewBranchOk(): void
    {
        $this->mockCommandExecutor->nextOk();

        self::assertTrue($this->makeBranchCommand()->checkout('master'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\BranchCommand::newBranch
     */
    public function testNewBranchOnAlreadyExists(): void
    {
        $this->mockCommandExecutor->nextFailed("fatal: A branch named 'test' already exists");

        self::expectException(BranchAlreadyExists::class);

        $this->makeBranchCommand()->newBranch('test');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\BranchCommand::getCurrentBranch
     */
    public function testGetCurrentBranch(): void
    {
        $this->mockCommandExecutor->nextOk('dev ');

        self::assertEquals('dev', $this->makeBranchCommand()->getCurrentBranch());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\BranchCommand::switchBranch
     */
    public function testSwitchBranchOnGood(): void
    {
        $this->mockCommandExecutor->nextOk('Switched to branch \'master\'');

        self::assertTrue($this->makeBranchCommand()->switchBranch('master'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\BranchCommand::switchBranch
     */
    public function testSwitchBranchOnInvalidReference(): void
    {
        self::expectException(ReferenceInvalid::class);

        $this->mockCommandExecutor->nextFailed('fatal: invalid reference: master');

        $this->makeBranchCommand()->switchBranch('master');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\BranchCommand::switchBranch
     */
    public function testSwitchBranchOnAlreadySwitched(): void
    {
        self::expectException(AlreadySwitched::class);

        $this->mockCommandExecutor->nextFailed('Already on \'master\'');

        $this->makeBranchCommand()->switchBranch('master');
    }

    private function makeBranchCommand(): BranchCommand
    {
        return new BranchCommand($this->mockCommandBuilder, $this->mockCommandExecutor);
    }
}
