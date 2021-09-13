<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Commands;

use ArtARTs36\GitHandler\Command\Commands\SubmoduleCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitConfigCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitIndexCommand;
use ArtARTs36\GitHandler\Exceptions\SubmoduleNotFound;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;

final class SubmoduleCommandTest extends GitTestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\SubmoduleCommand::add
     * @covers \ArtARTs36\GitHandler\Command\Commands\SubmoduleCommand::__construct
     */
    public function testAddOk(): void
    {
        $this->mockCommandExecutor->nextOk();

        self::assertNull($this->makeSubmoduleCommand()->add('http://github.com/artarts36/str'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\SubmoduleCommand::sync
     */
    public function testSync(): void
    {
        $this->mockCommandExecutor->nextOk();

        self::assertNull($this->makeSubmoduleCommand()->sync('str'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\SubmoduleCommand::remove
     */
    public function testRemoveOnSubmoduleNotFound(): void
    {
        $command = $this->makeSubmoduleCommand();

        $this->mockFileSystem->createFile($command->getPath(), '');

        self::expectException(SubmoduleNotFound::class);

        $command->remove('str');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\SubmoduleCommand::remove
     */
    public function testRemoveOk(): void
    {
        $command = $this->makeSubmoduleCommand();

        $this->mockCommandExecutor->nextAttemptsOk(2);

        $this->mockFileSystem->createFile($command->getPath(), '[submodule "str"]
	path = $submodule->path
	url = $submodule->url');

        self::assertNull($command->remove('str'));
    }

    private function makeSubmoduleCommand(
        ?GitConfigCommand $config = null,
        ?GitIndexCommand $index = null
    ): SubmoduleCommand {
        return new SubmoduleCommand(
            $config ?? $this->mockGitHandler->config(),
            $index ?? $this->mockGitHandler->index(),
            $this->mockGitContext,
            $this->mockFileSystem,
            $this->mockCommandBuilder,
            $this->mockCommandExecutor
        );
    }
}
