<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Exceptions\RemoteAlreadyExists;
use ArtARTs36\GitHandler\Exceptions\RemoteRepositoryNotFound;
use ArtARTs36\GitHandler\Exceptions\UnexpectedException;

class RemoteOperationsTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Git::showRemote
     * @covers \ArtARTs36\GitHandler\Git::executeShowRemote
     */
    public function testShowRemoteOnRemoteNotFound(): void
    {
        $git = $this->mockGit("remote: Repository not found.
fatal: repository 'https://github.com/ArtARTs36/test/' not found
");

        self::expectException(RemoteRepositoryNotFound::class);
        self::expectExceptionMessage('Remote Repository https://github.com/ArtARTs36/test/ not found');

        $git->showRemote();
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::showRemote
     * @covers \ArtARTs36\GitHandler\Git::executeShowRemote
     */
    public function testShowRemote(): void
    {
        $git = $this->mockGit('* remote origin
  Fetch URL: https://github.com/ArtARTs36/GitHandler.git
  Push  URL: https://github.com/ArtARTs36/GitHandler.git
  HEAD branch: master
  Remote branch:
    master tracked
  Local branch configured for \'git pull\':
    master merges with remote master
  Local ref configured for \'git push\':
    master pushes to master (up to date)
');

        $expected = [
            'fetch' => 'https://github.com/ArtARTs36/GitHandler.git',
            'push' => 'https://github.com/ArtARTs36/GitHandler.git',
        ];

        self::assertEquals($expected, $git->showRemote()->toArray());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::showRemote
     * @covers \ArtARTs36\GitHandler\Git::executeShowRemote
     */
    public function testShowRemoteEmpty(): void
    {
        $git = $this->mockGit(null);

        //

        $remotes = $git->showRemote();

        self::assertTrue($remotes->isEmpty());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::addRemote
     */
    public function testAddRemoteAlreadyExists(): void
    {
        $git = $this->mockGit('remote master already exists');

        self::expectException(RemoteAlreadyExists::class);

        $git->addRemote('m', 'https://site.ru');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::addRemote
     */
    public function testAddRemoteOnGood(): void
    {
        self::assertTrue($this->mockGit()->addRemote('m', 'https://site.ru'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::addRemote
     */
    public function testAddRemoteOnUnexpectedException(): void
    {
        self::expectException(UnexpectedException::class);

        $this->mockGit('random answer')->addRemote('s', 'https://site.ru');
    }
}
