<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Commands;

use ArtARTs36\GitHandler\Command\Commands\IndexCommand;
use ArtARTs36\GitHandler\Enum\ResetMode;
use ArtARTs36\GitHandler\Exceptions\FileNotFound;
use ArtARTs36\GitHandler\Exceptions\UnknownRevisionInWorkingTree;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;

final class IndexCommandTest extends GitTestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\IndexCommand::add
     */
    public function testAddOk(): void
    {
        $this->mockCommandExecutor->addSuccess();

        self::assertTrue($this->makeIndexCommand()->add('README.MD', true));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\IndexCommand::add
     */
    public function testAddOnNotFound(): void
    {
        self::expectException(FileNotFound::class);

        $this->mockCommandExecutor->addFail("pathspec 'random.file' did not match any files");

        $this->makeIndexCommand()->add('random.file');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\IndexCommand::reset
     */
    public function testResetOnUnknownRevision(): void
    {
        self::expectException(UnknownRevisionInWorkingTree::class);

        $this->mockCommandExecutor->addFail('unknown revision or path not in the working tree');

        $this->makeIndexCommand()->reset(ResetMode::from(ResetMode::SOFT), 'file.txt');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\IndexCommand::reset
     */
    public function testReset(): void
    {
        $this->mockCommandExecutor->addSuccess();

        self::assertNull($this->makeIndexCommand()->reset(ResetMode::from(ResetMode::SOFT), 'file.txt'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\IndexCommand::remove
     * @covers \ArtARTs36\GitHandler\Command\Commands\IndexCommand::buildRemoveCommand
     */
    public function testRemoveOk(): void
    {
        $this->mockCommandExecutor->addSuccess();

        self::assertNull($this->makeIndexCommand()->remove('file.txt'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\IndexCommand::remove
     * @covers \ArtARTs36\GitHandler\Command\Commands\IndexCommand::buildRemoveCommand
     */
    public function testRemoveOnFileNotFound(): void
    {
        self::expectException(FileNotFound::class);

        $this->mockCommandExecutor->addFail("pathspec 'f.txt' did not match any");
        $this->makeIndexCommand()->remove('f.txt', true);
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\IndexCommand::removeCached
     * @covers \ArtARTs36\GitHandler\Command\Commands\IndexCommand::buildRemoveCommand
     */
    public function testRemoveCachedOk(): void
    {
        $this->mockCommandExecutor->addSuccess();

        self::assertNull($this->makeIndexCommand()->removeCached('file.txt'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\IndexCommand::removeCached
     * @covers \ArtARTs36\GitHandler\Command\Commands\IndexCommand::buildRemoveCommand
     */
    public function testRemoveCachedOnFileNotFound(): void
    {
        self::expectException(FileNotFound::class);

        $this->mockCommandExecutor->addFail("pathspec 'f.txt' did not match any");
        $this->makeIndexCommand()->removeCached('f.txt', true);
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\IndexCommand::checkout
     * @covers \ArtARTs36\GitHandler\Command\Commands\IndexCommand::buildPureCheckoutCommand
     * @covers \ArtARTs36\GitHandler\Exceptions\FileNotFound::handleIfSo
     */
    public function testCheckoutOk(): void
    {
        $this->mockCommandExecutor->addSuccess("Already on 'master'");

        self::assertTrue($this->makeIndexCommand()->checkout('master', true));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\IndexCommand::checkout
     * @covers \ArtARTs36\GitHandler\Command\Commands\IndexCommand::buildPureCheckoutCommand
     * @covers \ArtARTs36\GitHandler\Exceptions\FileNotFound::handleIfSo
     */
    public function testCheckoutOnNotFoundBranch(): void
    {
        self::expectException(FileNotFound::class);

        $this->mockCommandExecutor->addFail("pathspec 'random' did not match any");

        $this->makeIndexCommand()->checkout('random');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\IndexCommand::rollback
     * @covers \ArtARTs36\GitHandler\Command\Commands\IndexCommand::buildPureCheckoutCommand
     * @covers \ArtARTs36\GitHandler\Exceptions\FileNotFound::handleIfSo
     */
    public function testRollbackOk(): void
    {
        $this->mockCommandExecutor->addSuccess("Already on 'master'");

        self::assertNull($this->makeIndexCommand()->rollback('master'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\IndexCommand::rollback
     * @covers \ArtARTs36\GitHandler\Command\Commands\IndexCommand::buildPureCheckoutCommand
     * @covers \ArtARTs36\GitHandler\Exceptions\FileNotFound::handleIfSo
     */
    public function testRollbackOnNotFoundBranch(): void
    {
        self::expectException(FileNotFound::class);

        $this->mockCommandExecutor->addFail("pathspec 'random' did not match any");

        $this->makeIndexCommand()->rollback('random');
    }

    private function makeIndexCommand(): IndexCommand
    {
        return new IndexCommand($this->mockCommandBuilder, $this->mockCommandExecutor);
    }
}
