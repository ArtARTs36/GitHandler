<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

class RemoteOperationsTest extends TestCase
{
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
}
