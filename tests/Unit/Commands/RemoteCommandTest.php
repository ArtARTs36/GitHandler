<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Commands;

use ArtARTs36\GitHandler\Command\Groups\RemoteCommand;
use ArtARTs36\GitHandler\Exceptions\RemoteAlreadyExists;
use ArtARTs36\GitHandler\Exceptions\RemoteNotFound;
use ArtARTs36\GitHandler\Exceptions\RemoteRepositoryNotFound;
use ArtARTs36\GitHandler\Tests\Unit\V2TestCase;

final class RemoteCommandTest extends V2TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\RemoteCommand::showRemote
     * @covers \ArtARTs36\GitHandler\Command\Groups\RemoteCommand::executeShowRemote
     */
    public function testShowRemoteOnRemoteNotFound(): void
    {
        self::expectException(RemoteRepositoryNotFound::class);
        self::expectExceptionMessage('Remote Repository https://github.com/ArtARTs36/test/ not found');

        $this->mockCommandExecutor->nextFailed("remote: Repository not found.
fatal: repository 'https://github.com/ArtARTs36/test/' not found
");

        $this->makeRemoteCommand()->showRemote();
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\RemoteCommand::showRemote
     * @covers \ArtARTs36\GitHandler\Command\Groups\RemoteCommand::executeShowRemote
     */
    public function testShowRemote(): void
    {
        $this->mockCommandExecutor->nextOk('origin  https://github.com/ArtARTs36/GitHandler.git (fetch)
origin  https://github.com/ArtARTs36/GitHandler.git (push)
');

        $expected = [
            'fetch' => 'https://github.com/ArtARTs36/GitHandler.git',
            'push' => 'https://github.com/ArtARTs36/GitHandler.git',
        ];

        self::assertEquals($expected, $this->makeRemoteCommand()->showRemote()->toArray());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\RemoteCommand::addRemote
     */
    public function testAddRemoteAlreadyExists(): void
    {
        $this->mockCommandExecutor->nextFailed('remote master already exists');

        self::expectException(RemoteAlreadyExists::class);

        $this->makeRemoteCommand()->addRemote('m', 'https://site.ru');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\RemoteCommand::addRemote
     */
    public function testAddRemoteOnGood(): void
    {
        $this->mockCommandExecutor->nextOk();

        self::assertTrue($this->makeRemoteCommand()->addRemote('m', 'https://site.ru'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\RemoteCommand::removeRemote
     */
    public function testRemoveRemote(): void
    {
        $this->mockCommandExecutor->nextOk();

        self::assertTrue($this->makeRemoteCommand()->removeRemote('origin'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\RemoteCommand::removeRemote
     */
    public function testRemoveRemoteOnNotFound(): void
    {
        self::expectException(RemoteNotFound::class);

        $this->mockCommandExecutor->nextFailed('No such remote: \'origin\'');

        $this->makeRemoteCommand()->removeRemote('origin');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\RemoteCommand::hasAnyRemoteUrl
     */
    public function testHasAnyRemoteUrl(): void
    {
        $this->mockCommandExecutor->nextOk("origin https://site.ru (push)");

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
