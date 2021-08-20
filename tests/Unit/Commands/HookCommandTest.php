<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Commands;

use ArtARTs36\GitHandler\Command\Commands\HookCommand;
use ArtARTs36\GitHandler\Data\GitContext;
use ArtARTs36\GitHandler\Exceptions\HookNotExists;
use ArtARTs36\GitHandler\Enum\HookName;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;

final class HookCommandTest extends GitTestCase
{
    protected function makeHookCommand(): HookCommand
    {
        return new HookCommand($this->mockFileSystem, $this->mockCommandExecutor, GitContext::make(__DIR__));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\HookCommand::has
     */
    public function testHasHookTrue(): void
    {
        $hooks = $this->makeHookCommand();

        $this->mockFileSystem->createFile($hooks->getHookPath(HookName::UPDATE), 'hook');

        self::assertTrue($hooks->has(HookName::from(HookName::UPDATE)));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\HookCommand::has
     */
    public function testHasHookFalse(): void
    {
        self::assertFalse($this->makeHookCommand()->has(HookName::from(HookName::UPDATE)));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\HookCommand::delete
     */
    public function testDeleteHookTrue(): void
    {
        $hooks = $this->makeHookCommand();

        $this->mockFileSystem->createFile($hooks->getHookPath(HookName::UPDATE), 'hook');

        self::assertTrue($hooks->delete(HookName::from(HookName::UPDATE)));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\HookCommand::delete
     */
    public function testDeleteHookOnNotExists(): void
    {
        $hooks = $this->makeHookCommand();

        self::expectException(HookNotExists::class);

        $hooks->delete(HookName::from(HookName::UPDATE));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\HookCommand::get
     * @covers \ArtARTs36\GitHandler\Command\Commands\HookCommand::makeHookObject
     */
    public function testGetHookGood(): void
    {
        $hooks = $this->makeHookCommand();

        $this->mockFileSystem->createFile($hooks->getHookPath(HookName::UPDATE), 'echo 1');

        $result = $hooks->get(HookName::from(HookName::UPDATE));

        self::assertEquals([
            'name' => HookName::UPDATE,
            'script' => 'echo 1',
        ], [
            'name' => $result->name,
            'script' => $result->script,
        ]);
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\HookCommand::get
     */
    public function testGetHookOnNotExists(): void
    {
        self::expectException(HookNotExists::class);

        $this->makeHookCommand()->get(HookName::from(HookName::UPDATE));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\HookCommand::add
     * @covers \ArtARTs36\GitHandler\Command\Commands\HookCommand::doAdd
     */
    public function testAddHookGood(): void
    {
        $this->mockCommandExecutor->nextOk();

        $hooks = $this->makeHookCommand();

        $hooks->add(HookName::from(HookName::UPDATE), 'ss');

        self::assertTrue($this->mockFileSystem->exists($hooks->getHookPath(HookName::UPDATE)));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\HookCommand::getAll
     */
    public function testGetHooksOnEmpty(): void
    {
        $hooks = $this->makeHookCommand();

        self::assertEquals([], $hooks->getAll());
        self::assertEquals([], $hooks->getAll());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\HookCommand::getAll
     */
    public function testGetHooksOnlyWorked(): void
    {
        $hooks = $this->makeHookCommand();

        $this->mockFileSystem->createDir($hooks->getHookPath());
        $this->mockFileSystem->createFile($hooks->getHookPath(HookName::UPDATE), 'ss');
        $this->mockFileSystem->createFile($hooks->getHookPath(HookName::UPDATE . '.sample'), 'ss');

        self::assertCount(1, $hooks->getAll());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\HookCommand::getAll
     */
    public function testGetHooks(): void
    {
        $hooks = $this->makeHookCommand();

        $this->mockFileSystem->createDir($hooks->getHookPath());
        $this->mockFileSystem->createFile($hooks->getHookPath(HookName::UPDATE), 'ss');
        $this->mockFileSystem->createFile($hooks->getHookPath(HookName::UPDATE . '.sample'), 'ss');

        self::assertCount(2, $hooks->getAll(false));
    }
}
