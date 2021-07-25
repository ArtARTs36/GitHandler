<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

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
}
