<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Commands;

use ArtARTs36\GitHandler\Command\Commands\InitCommand;
use ArtARTs36\GitHandler\Exceptions\RepositoryAlreadyExists;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;

final class InitCommandTest extends GitTestCase
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
     * @covers \ArtARTs36\GitHandler\Command\Commands\InitCommand::init
     */
    public function testInit(string $commandResult, bool $return, bool $dirExists): void
    {
        $this->mockCommandExecutor->nextOk($commandResult);
        $initCommand = $this->makeInitCommandGroup();

        //

        self::assertEquals($return, $initCommand->init());
        self::assertEquals($dirExists, $this->mockFileSystem->exists($this->mockGitContext->getGitDir()));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\InitCommand::init
     */
    public function testInitOnRepositoryAlreadyExists(): void
    {
        self::expectException(RepositoryAlreadyExists::class);

        $this->mockCommandExecutor->nextOk();
        $this->mockFileSystem->createDir($this->mockGitContext->getGitDir());

        $this->makeInitCommandGroup()->init();
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\InitCommand::isInit
     */
    public function testIsInitOnFalse(): void
    {
        $this->mockFileSystem->reset();

        $command = $this->makeInitCommandGroup();

        self::assertFalse($command->isInit());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\InitCommand::isInit
     */
    public function testIsInitOnTrue(): void
    {
        $this->mockFileSystem->reset()->createDir($this->mockGitContext->getGitDir());

        $command = $this->makeInitCommandGroup();

        self::assertTrue($command->isInit());
    }

    protected function makeInitCommandGroup(): InitCommand
    {
        return new InitCommand(
            $this->mockFileSystem,
            $this->mockGitContext,
            $this->mockCommandBuilder,
            $this->mockCommandExecutor
        );
    }
}
