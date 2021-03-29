<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Exceptions\RepositoryAlreadyExists;

class InitOperationsTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Git::init
     */
    public function testInit(): void
    {
        $response = $this->mockGit('error')
            ->init();

        self::assertFalse($response);

        //

        $response = ($git = $this->mockGit('Initialized empty Git repository in '))
            ->init();

        self::assertTrue($response);
        self::assertTrue($this->fileSystem->exists($git->getDir()));

        $this->fileSystem->createFile($git->pathToGitFolder(), '');

        //

        self::expectException(RepositoryAlreadyExists::class);

        $git->init();
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::isInit
     */
    public function testIsInit(): void
    {
        $this->fileSystem->reset();

        $git = $this->mockGit('');

        //

        self::assertFalse($git->isInit());

        //

        $this->fileSystem->createFile($git->pathToGitFolder(), '');

        self::assertTrue($git->isInit());
    }
}
