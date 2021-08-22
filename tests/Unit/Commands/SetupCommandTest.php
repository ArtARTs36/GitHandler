<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Commands;

use ArtARTs36\GitHandler\Command\Commands\RemoteCommand;
use ArtARTs36\GitHandler\Command\Commands\SetupCommand;
use ArtARTs36\GitHandler\Data\GitContext;
use ArtARTs36\GitHandler\Exceptions\PathAlreadyExists;
use ArtARTs36\GitHandler\Exceptions\RemoteNotFilled;
use ArtARTs36\GitHandler\Exceptions\RepositoryAlreadyExists;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;

final class SetupCommandTest extends GitTestCase
{
    public function provideForTestInit(): array
    {
        return [
            [
                'error',
                false,
                false,
            ],
        ];
    }

    /**
     * @dataProvider provideForTestInit
     * @covers \ArtARTs36\GitHandler\Command\Commands\SetupCommand::init
     */
    public function testInit(string $commandResult, bool $return, bool $dirExists): void
    {
        $this->mockCommandExecutor->nextOk($commandResult);
        $initCommand = $this->makeSetupCommand();

        //

        self::assertEquals($return, $initCommand->init());
        self::assertEquals($dirExists, $this->mockFileSystem->exists($this->mockGitContext->getGitDir()));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\SetupCommand::init
     */
    public function testInitOnRepositoryAlreadyExists(): void
    {
        self::expectException(RepositoryAlreadyExists::class);

        $this->mockCommandExecutor->nextOk();
        $this->mockFileSystem->createDir($this->mockGitContext->getGitDir());

        $this->makeSetupCommand()->init();
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\SetupCommand::isInit
     */
    public function testIsInitOnFalse(): void
    {
        $this->mockFileSystem->reset();

        $command = $this->makeSetupCommand();

        self::assertFalse($command->isInit());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\SetupCommand::isInit
     */
    public function testIsInitOnTrue(): void
    {
        $this->mockFileSystem->reset()->createDir($this->mockGitContext->getGitDir());

        $command = $this->makeSetupCommand();

        self::assertTrue($command->isInit());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\SetupCommand::clone
     */
    public function testCloneOk(): void
    {
        $this->mockGitContext = GitContext::make('/var/web/project');
        $folder = 'project';
        $url = 'http://url.git';

        //

        $this->mockCommandExecutor->nextOk("Cloning into '{$folder}' ...");

        self::assertTrue($this->makeSetupCommand()->clone($url));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\SetupCommand::clone
     */
    public function testCloneOnPathAlreadyExists(): void
    {
        $this->mockGitContext = GitContext::make('/var/web/project');
        $folder = 'project';
        $url = 'http://url.git';

        self::expectException(PathAlreadyExists::class);

        $this->mockCommandExecutor->nextFailed("fatal: destination path '{$folder}' already exists " .
            "and is not an empty directory.");

        $this->makeSetupCommand()->clone($url, 'master');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\SetupCommand::delete
     */
    public function testDelete(): void
    {
        $this->mockFileSystem->createDir($this->mockGitContext->getRootDir());

        $this->makeSetupCommand()->delete();

        self::assertFalse($this->mockFileSystem->exists($this->mockGitContext->getRootDir()));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\SetupCommand::reinstall
     */
    public function testReinstallOnRemoteNotFilled(): void
    {
        $command = $this->makeSetupCommand();

        $this->mockCommandExecutor->nextOk();

        self::expectException(RemoteNotFilled::class);

        $command->reinstall();
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\SetupCommand::reinstall
     */
    public function testReinstallOk(): void
    {
        $command = $this->makeSetupCommand();
        $this->mockCommandExecutor->nextOk('origin https://github.com(fetch)')->nextOk();

        self::assertNull($command->reinstall('master'));
    }

    private function makeSetupCommand(): SetupCommand
    {
        return new SetupCommand(
            new RemoteCommand($this->mockCommandBuilder, $this->mockCommandExecutor),
            $this->mockFileSystem,
            $this->mockGitContext,
            $this->mockCommandBuilder,
            $this->mockCommandExecutor
        );
    }
}
