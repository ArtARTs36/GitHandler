<?php

namespace ArtARTs36\ShellCommand\Tests\Unit\CommandGroups;

use ArtARTs36\GitHandler\Command\Groups\AbstractCommandGroup;
use ArtARTs36\GitHandler\Command\Groups\PathCommandGroup;
use ArtARTs36\GitHandler\Tests\Unit\V2TestCase;

class PathCommandGroupTest extends V2TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Git::getHtmlPath
     * @covers \ArtARTs36\GitHandler\Git::getPathByOption
     */
    public function tesHtmlPath(): void
    {
        $paths = new PathCommandGroup(
            $this->mockCommandBuilder,
            $this->mockCommandExecutor->nextOk('/Applications/Xcode.app/Contents/Developer/usr/share/doc/git-doc')
        );

        self::assertEquals('/Applications/Xcode.app/Contents/Developer/usr/share/doc/git-doc', $paths->html());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::getManPath
     * @covers \ArtARTs36\GitHandler\Git::getPathByOption
     */
    public function testManPath(): void
    {
        $paths = new PathCommandGroup(
            $this->mockCommandBuilder,
            $this->mockCommandExecutor->nextOk('/Applications/Xcode.app/Contents/Developer/usr/share/man
')
        );

        self::assertEquals('/Applications/Xcode.app/Contents/Developer/usr/share/man', $paths->man());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::getInfoPath
     * @covers \ArtARTs36\GitHandler\Git::getPathByOption
     */
    public function testInfoPath(): void
    {
        $paths = new PathCommandGroup(
            $this->mockCommandBuilder,
            $this->mockCommandExecutor->nextOk('/Applications/Xcode.app/Contents/Developer/usr/share/info')
        );

        self::assertEquals('/Applications/Xcode.app/Contents/Developer/usr/share/info', $paths->man());
    }
}
