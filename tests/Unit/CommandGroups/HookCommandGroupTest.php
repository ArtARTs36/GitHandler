<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Command\Groups\HookCommandGroup;
use ArtARTs36\GitHandler\Exceptions\HookNotExists;
use ArtARTs36\GitHandler\Exceptions\UnexpectedException;
use ArtARTs36\GitHandler\GitContext;
use ArtARTs36\GitHandler\Support\HookName;

class HookCommandGroupTest extends V2TestCase
{
    protected function makeHookCommandGroup(): HookCommandGroup
    {
        return new HookCommandGroup($this->mockFileSystem, $this->mockCommandExecutor, GitContext::make(__DIR__));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\HookCommandGroup::has
     */
    public function testHasHookTrue(): void
    {
        $hooks = $this->makeHookCommandGroup();

        $this->mockFileSystem->createFile($hooks->getHookPath(HookName::UPDATE), 'hook');

        self::assertTrue($hooks->has(HookName::UPDATE));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\HookCommandGroup::has
     */
    public function testHasHookFalse(): void
    {
        self::assertFalse($this->makeHookCommandGroup()->has(HookName::UPDATE));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\HookCommandGroup::delete
     */
    public function testDeleteHookTrue(): void
    {
        $hooks = $this->makeHookCommandGroup();

        $this->mockFileSystem->createFile($hooks->getHookPath(HookName::UPDATE), 'hook');

        self::assertTrue($hooks->delete(HookName::UPDATE));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\HookCommandGroup::delete
     */
    public function testDeleteHookOnNotExists(): void
    {
        $hooks = $this->makeHookCommandGroup();

        self::expectException(HookNotExists::class);

        $hooks->delete(HookName::UPDATE);
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\HookCommandGroup::makeHookObject
     * @covers \ArtARTs36\GitHandler\Command\Groups\HookCommandGroup::makeHookObject
     */
    public function testGetHookGood(): void
    {
        $hooks = $this->makeHookCommandGroup();

        $this->mockFileSystem->createFile($hooks->getHookPath(HookName::UPDATE), 'echo 1');

        $result = $hooks->get(HookName::UPDATE);

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

        $this->makeHookCommandGroup()->get(HookName::UPDATE);
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\HookCommandGroup::add
     */
    public function testAddHookOnUnexpectedError(): void
    {
        $hooks = $this->makeHookCommandGroup();

        self::expectException(UnexpectedException::class);

        $hooks->add(HookName::UPDATE, 'ss');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\HookCommandGroup::add
     */
    public function testAddHookGood(): void
    {
        $this->mockCommandExecutor->nextOk();

        $hooks = $this->makeHookCommandGroup();

        $hooks->add(HookName::UPDATE, 'ss');

        self::assertTrue($this->mockFileSystem->exists($hooks->getHookPath(HookName::UPDATE)));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::getHooks
     */
    public function testGetHooksOnEmpty(): void
    {
        $hooks = $this->makeHookCommandGroup();

        self::assertEquals([], $hooks->getAll());
        self::assertEquals([], $hooks->getAll());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\HookCommandGroup::getAll
     */
    public function testGetHooksOnlyWorked(): void
    {
        $hooks = $this->makeHookCommandGroup();

        $this->mockFileSystem->createDir($hooks->getHookPath());
        $this->mockFileSystem->createFile($hooks->getHookPath(HookName::UPDATE), 'ss');
        $this->mockFileSystem->createFile($hooks->getHookPath(HookName::UPDATE . '.sample'), 'ss');

        self::assertCount(1, $hooks->getAll());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\HookCommandGroup::getAll
     */
    public function testGetHooks(): void
    {
        $hooks = $this->makeHookCommandGroup();

        $this->mockFileSystem->createDir($hooks->getHookPath());
        $this->mockFileSystem->createFile($hooks->getHookPath(HookName::UPDATE), 'ss');
        $this->mockFileSystem->createFile($hooks->getHookPath(HookName::UPDATE . '.sample'), 'ss');

        self::assertCount(2, $hooks->getAll(false));
    }
}
