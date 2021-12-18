<?php

namespace ArtARTs36\ShellCommand\Tests\Unit\Commands;

use ArtARTs36\GitHandler\Command\Commands\PathCommand;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;

final class PathCommandTest extends GitTestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\PathCommand::html
     * @covers \ArtARTs36\GitHandler\Command\Commands\PathCommand::getPathByOption
     */
    public function testHtmlPath(): void
    {
        $paths = new PathCommand(
            $this->mockCommandBuilder,
            $this->mockCommandExecutor->addSuccess('/Applications/Xcode.app/Contents/Developer/usr/share/doc/git-doc')
        );

        self::assertEquals('/Applications/Xcode.app/Contents/Developer/usr/share/doc/git-doc', $paths->html());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\PathCommand::man
     * @covers \ArtARTs36\GitHandler\Command\Commands\PathCommand::getPathByOption
     */
    public function testManPath(): void
    {
        $paths = new PathCommand(
            $this->mockCommandBuilder,
            $this->mockCommandExecutor->addSuccess('/Applications/Xcode.app/Contents/Developer/usr/share/man
')
        );

        self::assertEquals('/Applications/Xcode.app/Contents/Developer/usr/share/man', $paths->man());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\PathCommand::info
     * @covers \ArtARTs36\GitHandler\Command\Commands\PathCommand::getPathByOption
     */
    public function testInfoPath(): void
    {
        $paths = new PathCommand(
            $this->mockCommandBuilder,
            $this->mockCommandExecutor->addSuccess('/Applications/Xcode.app/Contents/Developer/usr/share/info')
        );

        self::assertEquals('/Applications/Xcode.app/Contents/Developer/usr/share/info', $paths->info());
    }
}
