<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Factory;

use ArtARTs36\GitHandler\CachedGit;
use ArtARTs36\GitHandler\Command\GitCommandBuilder;
use ArtARTs36\GitHandler\Contracts\Factory\GitHandlerFactory;
use ArtARTs36\GitHandler\Contracts\Handler\GitHandler;
use ArtARTs36\GitHandler\Data\GitContext;
use ArtARTs36\GitHandler\Factory\CachedGitFactory;
use ArtARTs36\GitHandler\Git;
use ArtARTs36\GitHandler\Tests\Support\ArrayFileSystem;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;
use ArtARTs36\ShellCommand\Executors\TestExecutor;
use ArtARTs36\ShellCommand\ShellCommander;

final class CachedGitFactoryTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Factory\CachedGitFactory::factory
     * @covers \ArtARTs36\GitHandler\Factory\CachedGitFactory::__construct
     */
    public function testFactory(): void
    {
        $decorableFactory = new TestGitFactory();

        $cachedFactory = new CachedGitFactory($decorableFactory);

        $expected = [
            'instance'    => CachedGit::class,
            'decorable'   => TestGitHandler::class,
        ];

        $givenGit = $cachedFactory->factory(__DIR__);

        self::assertEquals($expected, [
            'instance'  => get_class($givenGit),
            'decorable' => get_class($this->getPropertyValueOfObject($givenGit, 'git')),
        ]);
    }
}

/**
 * @codingStandardsIgnoreStart
 */
class TestGitFactory implements GitHandlerFactory
{
    public function factory(string $dir, string $bin = 'git'): GitHandler
    {
        return new TestGitHandler(
            new GitCommandBuilder(new ShellCommander(), $bin, $dir),
            new TestExecutor(),
            new ArrayFileSystem(),
            GitContext::make($dir)
        );
    }
}

class TestGitHandler extends Git
{
    //
}
