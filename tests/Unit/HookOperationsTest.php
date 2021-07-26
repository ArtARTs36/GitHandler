<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Exceptions\HookNotExists;
use ArtARTs36\GitHandler\Exceptions\UnexpectedException;
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

    /**
     * @covers \ArtARTs36\GitHandler\Git::getHook
     */
    public function testGetHookGood(): void
    {
        $git = $this->mockGit();

        $this->fileSystem->createFile($git->getHookPath(HookName::UPDATE), 'echo 1');

        $result = $git->getHook(HookName::UPDATE);

        self::assertEquals([
            'name' => HookName::UPDATE,
            'script' => 'echo 1',
        ], [
            'name' => $result->name,
            'script' => $result->script,
        ]);
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::getHook
     */
    public function testGetHookOnNotExists(): void
    {
        self::expectException(HookNotExists::class);

        $this->mockGit()->getHook(HookName::UPDATE);
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::addHook
     */
    public function testAddHookOnUnexpectedError(): void
    {
        $git = $this->mockGit('chmod error');

        self::expectException(UnexpectedException::class);

        $git->addHook(HookName::UPDATE, 'ss');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::addHook
     */
    public function testAddHookGood(): void
    {
        $git = $this->mockGit();

        $git->addHook(HookName::UPDATE, 'ss');

        self::assertTrue($this->fileSystem->exists($git->getHookPath(HookName::UPDATE)));
    }
}
