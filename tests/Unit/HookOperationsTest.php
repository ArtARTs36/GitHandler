<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Exceptions\HookNotExists;
use ArtARTs36\GitHandler\Support\HookName;

class HookOperationsTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Git::hasHook
     */
    public function testHasHookTrue(): void
    {
        $git = $this->mockGit();

        $this->fileSystem->createFile($git->getHookPath(HookName::UPDATE), 'hook');

        self::assertTrue($git->hasHook(HookName::UPDATE));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::hasHook
     */
    public function testHasHookFalse(): void
    {
        self::assertFalse($this->mockGit()->hasHook(HookName::UPDATE));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::deleteHook
     */
    public function testDeleteHookTrue(): void
    {
        $git = $this->mockGit();

        $this->fileSystem->createFile($git->getHookPath(HookName::UPDATE), 'hook');

        self::assertTrue($git->deleteHook(HookName::UPDATE));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::deleteHook
     */
    public function testDeleteHookOnNotExists(): void
    {
        $git = $this->mockGit();

        self::expectException(HookNotExists::class);

        $git->deleteHook(HookName::UPDATE);
    }
}
