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
        $this->mockCommandExecutor->addSuccess('Deleted branch config (was a48b10d).');

        self::assertTrue($this->makeBranchCommand()->delete('config'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\BranchCommand::delete
     */
    public function testDeleteBranchOnBranchNotFound(): void
    {
        self::expectException(BranchNotFound::class);

        $this->mockCommandExecutor->addFail("error: branch 'test' not found");

        $this->makeBranchCommand()->delete('test');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\BranchCommand::create
     */
    public function testNewBranchOnInvalidObjectName(): void
    {
        self::expectException(ObjectNameNotValid::class);

        $this->mockCommandExecutor->addFail('fatal: Not a valid object name: \'1234\'');

        $this->makeBranchCommand()->create('master');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\BranchCommand::getAll
     */
    public function testGetAll(): void
    {
        $this->mockCommandExecutor->addSuccess("  eee
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
     * @covers \ArtARTs36\GitHandler\Command\Commands\BranchCommand::create
     */
    public function testNewBranchOk(): void
    {
        $this->mockCommandExecutor->addSuccess();

        self::assertNull($this->makeBranchCommand()->create('master'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\BranchCommand::create
     */
    public function testNewBranchOnAlreadyExists(): void
    {
        $this->mockCommandExecutor->addFail("fatal: A branch named 'test' already exists");

        self::expectException(BranchAlreadyExists::class);

        $this->makeBranchCommand()->create('test');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\BranchCommand::current
     */
    public function testGetCurrentBranch(): void
    {
        $this->mockCommandExecutor->addSuccess('dev ');

        self::assertEquals('dev', $this->makeBranchCommand()->current());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\BranchCommand::switch
     */
    public function testSwitchBranchOnGood(): void
    {
        $this->mockCommandExecutor->addSuccess('Switched to branch \'master\'');

        self::assertTrue($this->makeBranchCommand()->switch('master'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\BranchCommand::switch
     */
    public function testSwitchBranchOnInvalidReference(): void
    {
        self::expectException(ReferenceInvalid::class);

        $this->mockCommandExecutor->addFail('fatal: invalid reference: master');

        $this->makeBranchCommand()->switch('master');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\BranchCommand::switch
     */
    public function testSwitchBranchOnAlreadySwitched(): void
    {
        self::expectException(AlreadySwitched::class);

        $this->mockCommandExecutor->addFail('Already on \'master\'');

        $this->makeBranchCommand()->switch('master');
    }

    private function makeBranchCommand(): BranchCommand
    {
        return new BranchCommand($this->mockCommandBuilder, $this->mockCommandExecutor);
    }
}
