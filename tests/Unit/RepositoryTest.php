<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Repository;
use ArtARTs36\GitHandler\GitSimpleFactory;

class RepositoryTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Repository::createFolder
     */
    public function testCreateFolder(): void
    {
        $dir = $this->getTmpDir();

        $git = GitSimpleFactory::factory($dir);

        $action = new Repository($git, $this->fileSystem);

        $action->createFolder('test');

        //

        self::assertTrue($this->fileSystem->exists($dir . DIRECTORY_SEPARATOR . 'test'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Repository::createFile
     */
    public function testCreateFile(): void
    {
        $action = $this->mock();

        $action->createFile('test.php', 'echo hello world');

        self::assertTrue($this->fileSystem->exists($this->getTmpDir() . DIRECTORY_SEPARATOR . 'test.php'));

        //

        $action->createFile('test.php', 'echo hello world', 'test');

        self::assertTrue($this->fileSystem->exists(
            $this->getTmpDir() . DIRECTORY_SEPARATOR . 'test' . DIRECTORY_SEPARATOR . 'test.php'
        ));
    }

    private function mock(): Repository
    {
        $dir = $this->getTmpDir();

        $git = GitSimpleFactory::factory($dir, $this->fileSystem);

        return new Repository($git, $this->fileSystem);
    }
}
