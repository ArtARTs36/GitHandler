<?php

namespace ArtARTs36\HostReviewerCore\Tests\Unit;

use ArtARTs36\GitHandler\Action;
use ArtARTs36\GitHandler\Git;
use ArtARTs36\GitHandler\Support\FileSystem;
use PHPUnit\Framework\TestCase;

class ActionTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        mkdir($this->getTmpDir());
    }

    public function tearDown(): void
    {
        parent::tearDown();

        FileSystem::removeDir($this->getTmpDir());
    }

    public function testCreateFolder(): void
    {
        $dir = $this->getTmpDir();

        $git = new Git($dir);

        $action = new Action($git);

        $action->createFolder('test');

        //

        self::assertFileExists($dir . DIRECTORY_SEPARATOR . 'test');
    }

    private function getTmpDir(): string
    {
        return __DIR__ . '/../' . '__tmp';
    }
}
