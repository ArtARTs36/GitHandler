<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Commands;

use ArtARTs36\GitHandler\Command\Commands\SubmoduleCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitConfigCommand;
use ArtARTs36\GitHandler\Contracts\Commands\GitIndexCommand;
use ArtARTs36\GitHandler\Exceptions\SubmoduleNotFound;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;

final class SubmoduleCommandTest extends GitTestCase
{
    public function providerForTestExists(): array
    {
        return [
            [
                null,
                'random-name',
                false,
            ],
            [
                '[submodule "str"]
	path = str
	url = https://github.com/ArtARTs36/str',
                'str',
                true,
            ],
            [
                '[submodule "str"]
	path = str
	url = https://github.com/ArtARTs36/str1',
                'str',
                true,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\SubmoduleCommand::add
     * @covers \ArtARTs36\GitHandler\Command\Commands\SubmoduleCommand::__construct
     */
    public function testAddOk(): void
    {
        $this->mockCommandExecutor->addSuccess();

        self::assertNull($this->makeSubmoduleCommand()->add('http://github.com/artarts36/str'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\SubmoduleCommand::sync
     */
    public function testSync(): void
    {
        $this->mockCommandExecutor->addSuccess();

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

        $this->mockCommandExecutor->addSuccesses(2);

        $this->mockFileSystem->createFile($command->getPath(), '[submodule "str"]
	path = $submodule->path
	url = $submodule->url');

        self::assertNull($command->remove('str'));
    }

    /**
     * @dataProvider providerForTestExists
     * @covers \ArtARTs36\GitHandler\Command\Commands\SubmoduleCommand::exists
     * @covers \ArtARTs36\GitHandler\Command\Commands\SubmoduleCommand::isFileExists
     * @covers \ArtARTs36\GitHandler\Command\Commands\SubmoduleCommand::getPath
     * @covers \ArtARTs36\GitHandler\Command\Commands\SubmoduleCommand::doExists
     */
    public function testExists(?string $content, string $module, bool $expected): void
    {
        $command = $this->makeSubmoduleCommand();

        $content !== null && $this->mockFileSystem->createFile($command->getPath(), $content);

        self::assertEquals($expected, $command->exists($module));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\SubmoduleCommand::syncDefinesFromConfig
     * @covers \ArtARTs36\GitHandler\Command\Commands\SubmoduleCommand::saveFromMap
     */
    public function testSyncDefinesFromConfig(): void
    {
        $command = $this->makeSubmoduleCommand();

        $this->mockCommandExecutor->addSuccess('submodule.str.url=github.com');

        $command->syncDefinesFromConfig();

        self::assertEquals('[submodule "str"]
	path = str
	url = github.com', $this->mockFileSystem->getFileContent($command->getPath()));
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
