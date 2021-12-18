<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Commands;

use ArtARTs36\GitHandler\Command\Commands\RemoteCommand;
use ArtARTs36\GitHandler\Exceptions\RemoteAlreadyExists;
use ArtARTs36\GitHandler\Exceptions\RemoteNotFound;
use ArtARTs36\GitHandler\Exceptions\RemoteRepositoryNotFound;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;

final class RemoteCommandTest extends GitTestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\RemoteCommand::show
     * @covers \ArtARTs36\GitHandler\Command\Commands\RemoteCommand::executeShowRemote
     */
    public function testShowRemoteOnRemoteNotFound(): void
    {
        self::expectException(RemoteRepositoryNotFound::class);
        self::expectExceptionMessage('Remote Repository https://github.com/ArtARTs36/test/ not found');

        $this->mockCommandExecutor->addFail("remote: Repository not found.
fatal: repository 'https://github.com/ArtARTs36/test/' not found
");

        $this->makeRemoteCommand()->show();
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\RemoteCommand::show
     * @covers \ArtARTs36\GitHandler\Command\Commands\RemoteCommand::executeShowRemote
     */
    public function testShowRemote(): void
    {
        $this->mockCommandExecutor->addSuccess('origin  https://github.com/ArtARTs36/GitHandler.git (fetch)
origin  https://github.com/ArtARTs36/GitHandler.git (push)
');

        $expected = [
            'fetch' => 'https://github.com/ArtARTs36/GitHandler.git',
            'push' => 'https://github.com/ArtARTs36/GitHandler.git',
        ];

        self::assertEquals($expected, $this->makeRemoteCommand()->show()->toArray());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\RemoteCommand::add
     */
    public function testAddRemoteAlreadyExists(): void
    {
        $this->mockCommandExecutor->addFail('remote master already exists');

        self::expectException(RemoteAlreadyExists::class);

        $this->makeRemoteCommand()->add('m', 'https://site.ru');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\RemoteCommand::add
     */
    public function testAddRemoteOnGood(): void
    {
        $this->mockCommandExecutor->addSuccess();

        self::assertTrue($this->makeRemoteCommand()->add('m', 'https://site.ru'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\RemoteCommand::remove
     */
    public function testRemoveRemote(): void
    {
        $this->mockCommandExecutor->addSuccess();

        self::assertTrue($this->makeRemoteCommand()->remove('origin'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\RemoteCommand::remove
     */
    public function testRemoveRemoteOnNotFound(): void
    {
        self::expectException(RemoteNotFound::class);

        $this->mockCommandExecutor->addFail('No such remote: \'origin\'');

        $this->makeRemoteCommand()->remove('origin');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\RemoteCommand::hasAnyRemoteUrl
     */
    public function testHasAnyRemoteUrl(): void
    {
        $this->mockCommandExecutor->addSuccess("origin https://site.ru (push)");

        self::assertTrue($this->makeRemoteCommand()->hasAnyRemoteUrl('https://site.ru'));
    }

    private function makeRemoteCommand(): RemoteCommand
    {
        return new RemoteCommand(
            $this->mockCommandBuilder,
            $this->mockCommandExecutor,
        );
    }
}
