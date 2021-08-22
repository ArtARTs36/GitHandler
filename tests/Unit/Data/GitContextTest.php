<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Data;

use ArtARTs36\GitHandler\Data\GitContext;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class GitContextTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Data\GitContext::make
     * @covers \ArtARTs36\GitHandler\Data\GitContext::__construct
     */
    public function testMakeOnOneParameter(): void
    {
        $context = GitContext::make(__DIR__);

        self::assertEquals([
            'rootDir' => __DIR__,
            'gitDir'  => __DIR__ . '/.git'
        ], $context->toArray());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Data\GitContext::getRootFolder
     * @covers \ArtARTs36\GitHandler\Data\GitContext::__construct
     */
    public function testGetRootFolder(): void
    {
        self::assertEquals('project', GitContext::make('/var/web/project')->getRootFolder());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Data\GitContext::getRootDir
     * @covers \ArtARTs36\GitHandler\Data\GitContext::__construct
     */
    public function testGetRootDir(): void
    {
        $path = '/var/web/project/';

        self::assertEquals($path, GitContext::make($path)->getRootDir());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Data\GitContext::getRefsDir
     * @covers \ArtARTs36\GitHandler\Data\GitContext::__construct
     */
    public function testGetRefsDir(): void
    {
        self::assertEquals(
            '/var/web/project/.git/refs',
            GitContext::make('/var/web/project')->getRefsDir()
        );
    }

    /**
     * @covers \ArtARTs36\GitHandler\Data\GitContext::getGitDir
     * @covers \ArtARTs36\GitHandler\Data\GitContext::__construct
     */
    public function testGetGitDir(): void
    {
        self::assertEquals(
            '/var/web/project/.git',
            (new GitContext('/var/web/project', '/var/web/project/.git'))->getGitDir()
        );
    }
}
