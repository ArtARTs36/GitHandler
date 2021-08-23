<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Commands;

use ArtARTs36\GitHandler\Command\Commands\BranchCommand;
use ArtARTs36\GitHandler\Exceptions\AlreadySwitched;
use ArtARTs36\GitHandler\Exceptions\BranchAlreadyExists;
use ArtARTs36\GitHandler\Exceptions\BranchNotFound;
use ArtARTs36\GitHandler\Exceptions\ObjectNameNotValid;
use ArtARTs36\GitHandler\Exceptions\ReferenceInvalid;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;

final class BranchCommandTest extends GitTestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\BranchCommand::delete
     */
    public function testDeleteOk(): void
    {
        $this->mockCommandExecutor->nextOk('Deleted branch config (was a48b10d).');

        self::assertTrue($this->makeBranchCommand()->delete('config'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\BranchCommand::delete
     * @covers \ArtARTs36\GitHandler\Exceptions\BranchNotFound::handleIfSo
     */
    public function testDeleteBranchOnBranchNotFound(): void
    {
        self::expectException(BranchNotFound::class);

        $this->mockCommandExecutor->nextFailed("error: branch 'test' not found");

        $this->makeBranchCommand()->delete('test');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\BranchCommand::create
     */
    public function testNewBranchOnInvalidObjectName(): void
    {
        self::expectException(ObjectNameNotValid::class);

        $this->mockCommandExecutor->nextFailed('fatal: Not a valid object name: \'1234\'');

        $this->makeBranchCommand()->create('master');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\BranchCommand::getAll
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
        ], $this->makeBranchCommand()->getAll());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\BranchCommand::checkout
     */
    public function testCheckoutOk(): void
    {
        $this->mockCommandExecutor->nextOk("Already on 'master'");

        self::assertTrue($this->makeBranchCommand()->checkout('master', true));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\BranchCommand::checkout
     */
    public function testCheckoutOnNotFoundBranch(): void
    {
        self::expectException(BranchNotFound::class);

        $this->mockCommandExecutor->nextFailed("pathspec 'random' did not match any");

        $this->makeBranchCommand()->checkout('random');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\BranchCommand::create
     */
    public function testNewBranchOk(): void
    {
        $this->mockCommandExecutor->nextOk();

        self::assertNull($this->makeBranchCommand()->create('master'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\BranchCommand::create
     */
    public function testNewBranchOnAlreadyExists(): void
    {
        $this->mockCommandExecutor->nextFailed("fatal: A branch named 'test' already exists");

        self::expectException(BranchAlreadyExists::class);

        $this->makeBranchCommand()->create('test');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\BranchCommand::current
     */
    public function testGetCurrentBranch(): void
    {
        $this->mockCommandExecutor->nextOk('dev ');

        self::assertEquals('dev', $this->makeBranchCommand()->current());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\BranchCommand::switch
     */
    public function testSwitchBranchOnGood(): void
    {
        $this->mockCommandExecutor->nextOk('Switched to branch \'master\'');

        self::assertTrue($this->makeBranchCommand()->switch('master'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\BranchCommand::switch
     */
    public function testSwitchBranchOnInvalidReference(): void
    {
        self::expectException(ReferenceInvalid::class);

        $this->mockCommandExecutor->nextFailed('fatal: invalid reference: master');

        $this->makeBranchCommand()->switch('master');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\BranchCommand::switch
     */
    public function testSwitchBranchOnAlreadySwitched(): void
    {
        self::expectException(AlreadySwitched::class);

        $this->mockCommandExecutor->nextFailed('Already on \'master\'');

        $this->makeBranchCommand()->switch('master');
    }

    private function makeBranchCommand(): BranchCommand
    {
        return new BranchCommand($this->mockCommandBuilder, $this->mockCommandExecutor);
    }
}
