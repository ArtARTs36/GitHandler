<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Command\Groups\BranchCommand;
use ArtARTs36\GitHandler\Command\Groups\CloneCommand;
use ArtARTs36\GitHandler\Command\Groups\CommitCommand;
use ArtARTs36\GitHandler\Command\Groups\ConfigCommand;
use ArtARTs36\GitHandler\Command\Groups\FileCommand;
use ArtARTs36\GitHandler\Command\Groups\GrepCommand;
use ArtARTs36\GitHandler\Command\Groups\HelpCommand;
use ArtARTs36\GitHandler\Command\Groups\HookCommand;
use ArtARTs36\GitHandler\Command\Groups\IgnoreCommand;
use ArtARTs36\GitHandler\Command\Groups\IndexCommand;
use ArtARTs36\GitHandler\Command\Groups\InitCommand;
use ArtARTs36\GitHandler\Command\Groups\LogCommand;
use ArtARTs36\GitHandler\Command\Groups\PathCommand;
use ArtARTs36\GitHandler\Command\Groups\PullCommand;
use ArtARTs36\GitHandler\Command\Groups\PushCommand;
use ArtARTs36\GitHandler\Command\Groups\RemoteCommand;
use ArtARTs36\GitHandler\Command\Groups\StashCommand;
use ArtARTs36\GitHandler\Command\Groups\StatusCommand;
use ArtARTs36\GitHandler\Command\Groups\TagCommand;

class GitFactoryMethodsTest extends GitTestCase
{
    public function providerForTestFactoryMethod(): array
    {
        return [
            ['helps', HelpCommand::class],
            ['paths', PathCommand::class],
            ['tags', TagCommand::class],
            ['hooks', HookCommand::class],
            ['logs', LogCommand::class],
            ['greps', GrepCommand::class],
            ['inits', InitCommand::class],
            ['branches', BranchCommand::class],
            ['index', IndexCommand::class],
            ['pushes', PushCommand::class],
            ['statuses', StatusCommand::class],
            ['commits', CommitCommand::class],
            ['stashes', StashCommand::class],
            ['config', ConfigCommand::class],
            ['remotes', RemoteCommand::class],
            ['ignores', IgnoreCommand::class],
            ['clones', CloneCommand::class],
            ['pulls', PullCommand::class],
            ['files', FileCommand::class],
        ];
    }

    /**
     * @dataProvider providerForTestFactoryMethod
     * @covers \ArtARTs36\GitHandler\Git::helps
     * @covers \ArtARTs36\GitHandler\Git::paths
     * @covers \ArtARTs36\GitHandler\Git::tags
     * @covers \ArtARTs36\GitHandler\Git::hooks
     * @covers \ArtARTs36\GitHandler\Git::logs
     * @covers \ArtARTs36\GitHandler\Git::greps
     * @covers \ArtARTs36\GitHandler\Git::inits
     * @covers \ArtARTs36\GitHandler\Git::branches
     * @covers \ArtARTs36\GitHandler\Git::index
     * @covers \ArtARTs36\GitHandler\Git::pushes
     * @covers \ArtARTs36\GitHandler\Git::statuses
     * @covers \ArtARTs36\GitHandler\Git::commits
     * @covers \ArtARTs36\GitHandler\Git::stashes
     * @covers \ArtARTs36\GitHandler\Git::config
     * @covers \ArtARTs36\GitHandler\Git::remotes
     * @covers \ArtARTs36\GitHandler\Git::ignores
     * @covers \ArtARTs36\GitHandler\Git::clones
     * @covers \ArtARTs36\GitHandler\Git::pulls
     * @covers \ArtARTs36\GitHandler\Git::files
     */
    public function testFactoryMethod(string $method, string $expectedClass): void
    {
        self::assertInstanceOf($expectedClass, $this->callMethodFromObject($this->mockGitHandler, $method));
    }
}
