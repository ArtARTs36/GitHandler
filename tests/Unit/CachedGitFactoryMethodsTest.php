<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\CachedGit;

final class CachedGitFactoryMethodsTest extends GitTestCase
{
    public function providerForTestFactoryMethod(): array
    {
        return [
            ['helps'],
            ['paths'],
            ['tags'],
            ['hooks'],
            ['logs'],
            ['greps'],
            ['setup'],
            ['branches'],
            ['index'],
            ['pushes'],
            ['statuses'],
            ['commits'],
            ['stashes'],
            ['config'],
            ['remotes'],
            ['ignores'],
            ['pulls'],
            ['files'],
            ['archives'],
            ['transaction'],
            ['garbage'],
            ['merges'],
            ['attributes'],
            ['submodules'],
            ['backup'],
        ];
    }

    /**
     * @dataProvider providerForTestFactoryMethod
     * @covers \ArtARTs36\GitHandler\CachedGit::helps
     * @covers \ArtARTs36\GitHandler\CachedGit::paths
     * @covers \ArtARTs36\GitHandler\CachedGit::tags
     * @covers \ArtARTs36\GitHandler\CachedGit::hooks
     * @covers \ArtARTs36\GitHandler\CachedGit::logs
     * @covers \ArtARTs36\GitHandler\CachedGit::greps
     * @covers \ArtARTs36\GitHandler\CachedGit::setup
     * @covers \ArtARTs36\GitHandler\CachedGit::branches
     * @covers \ArtARTs36\GitHandler\CachedGit::index
     * @covers \ArtARTs36\GitHandler\CachedGit::pushes
     * @covers \ArtARTs36\GitHandler\CachedGit::statuses
     * @covers \ArtARTs36\GitHandler\CachedGit::commits
     * @covers \ArtARTs36\GitHandler\CachedGit::stashes
     * @covers \ArtARTs36\GitHandler\CachedGit::config
     * @covers \ArtARTs36\GitHandler\CachedGit::remotes
     * @covers \ArtARTs36\GitHandler\CachedGit::ignores
     * @covers \ArtARTs36\GitHandler\CachedGit::pulls
     * @covers \ArtARTs36\GitHandler\CachedGit::files
     * @covers \ArtARTs36\GitHandler\CachedGit::archives
     * @covers \ArtARTs36\GitHandler\CachedGit::transaction
     * @covers \ArtARTs36\GitHandler\CachedGit::garbage
     * @covers \ArtARTs36\GitHandler\CachedGit::merges
     * @covers \ArtARTs36\GitHandler\CachedGit::attributes
     * @covers \ArtARTs36\GitHandler\CachedGit::submodules
     * @covers \ArtARTs36\GitHandler\CachedGit::backup
     * @covers \ArtARTs36\GitHandler\CachedGit::cachedAndReturn
     * @covers \ArtARTs36\GitHandler\CachedGit::__construct
     */
    public function testFactoryMethod(string $method): void
    {
        $git = new CachedGit($this->mockGitHandler);

        self::assertEquals(
            spl_object_id($this->callMethodFromObject($git, $method)),
            spl_object_id($this->callMethodFromObject($git, $method))
        );
    }
}
