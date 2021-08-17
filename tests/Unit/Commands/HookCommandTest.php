<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Commands;

use ArtARTs36\GitHandler\Command\Groups\HookCommand;
use ArtARTs36\GitHandler\Data\GitContext;
use ArtARTs36\GitHandler\Exceptions\HookNotExists;
use ArtARTs36\GitHandler\Support\HookName;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;

final class HookCommandTest extends GitTestCase
{
    protected function makeHookCommandGroup(): HookCommand
    {
        return new HookCommand($this->mockFileSystem, $this->mockCommandExecutor, GitContext::make(__DIR__));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\HookCommand::has
     */
    public function testHasHookTrue(): void
    {
        $hooks = $this->makeHookCommandGroup();

        $this->mockFileSystem->createFile($hooks->getHookPath(HookName::UPDATE), 'hook');

        self::assertTrue($hooks->has(HookName::UPDATE));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\HookCommand::has
     */
    public function testHasHookFalse(): void
    {
        self::assertFalse($this->makeHookCommandGroup()->has(HookName::UPDATE));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\HookCommand::delete
     */
    public function testDeleteHookTrue(): void
    {
        $hooks = $this->makeHookCommandGroup();

        $this->mockFileSystem->createFile($hooks->getHookPath(HookName::UPDATE), 'hook');

        self::assertTrue($hooks->delete(HookName::UPDATE));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\HookCommand::delete
     */
    public function testDeleteHookOnNotExists(): void
    {
        $hooks = $this->makeHookCommandGroup();

        self::expectException(HookNotExists::class);

        $hooks->delete(HookName::UPDATE);
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\HookCommand::makeHookObject
     * @covers \ArtARTs36\GitHandler\Command\Groups\HookCommand::makeHookObject
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
     * @covers \ArtARTs36\GitHandler\Command\Groups\HookCommand::get
     */
    public function testGetHookOnNotExists(): void
    {
        self::expectException(HookNotExists::class);

        $this->makeHookCommandGroup()->get(HookName::UPDATE);
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\HookCommand::add
     */
    public function testAddHookGood(): void
    {
        $this->mockCommandExecutor->nextOk();

        $hooks = $this->makeHookCommandGroup();

        $hooks->add(HookName::UPDATE, 'ss');

        self::assertTrue($this->mockFileSystem->exists($hooks->getHookPath(HookName::UPDATE)));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\HookCommand::getAll
     */
    public function testGetHooksOnEmpty(): void
    {
        $hooks = $this->makeHookCommandGroup();

        self::assertEquals([], $hooks->getAll());
        self::assertEquals([], $hooks->getAll());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Groups\HookCommand::getAll
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
     * @covers \ArtARTs36\GitHandler\Command\Groups\HookCommand::getAll
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
