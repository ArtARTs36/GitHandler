<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Command\Commands\ArchiveCommand;
use ArtARTs36\GitHandler\Command\Commands\AttributeCommand;
use ArtARTs36\GitHandler\Command\Commands\BranchCommand;
use ArtARTs36\GitHandler\Command\Commands\CommitCommand;
use ArtARTs36\GitHandler\Command\Commands\ConfigCommand;
use ArtARTs36\GitHandler\Command\Commands\FileCommand;
use ArtARTs36\GitHandler\Command\Commands\GarbageCommand;
use ArtARTs36\GitHandler\Command\Commands\GrepCommand;
use ArtARTs36\GitHandler\Command\Commands\HelpCommand;
use ArtARTs36\GitHandler\Command\Commands\HookCommand;
use ArtARTs36\GitHandler\Command\Commands\IgnoreCommand;
use ArtARTs36\GitHandler\Command\Commands\IndexCommand;
use ArtARTs36\GitHandler\Command\Commands\MergeCommand;
use ArtARTs36\GitHandler\Command\Commands\SetupCommand;
use ArtARTs36\GitHandler\Command\Commands\LogCommand;
use ArtARTs36\GitHandler\Command\Commands\PathCommand;
use ArtARTs36\GitHandler\Command\Commands\PullCommand;
use ArtARTs36\GitHandler\Command\Commands\PushCommand;
use ArtARTs36\GitHandler\Command\Commands\RemoteCommand;
use ArtARTs36\GitHandler\Command\Commands\StashCommand;
use ArtARTs36\GitHandler\Command\Commands\StatusCommand;
use ArtARTs36\GitHandler\Command\Commands\SubmoduleCommand;
use ArtARTs36\GitHandler\Command\Commands\TagCommand;
use ArtARTs36\GitHandler\Transactions\ArchiveTransaction;
use ArtARTs36\GitHandler\Backup\Backup;

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
            ['setup', SetupCommand::class],
            ['branches', BranchCommand::class],
            ['index', IndexCommand::class],
            ['pushes', PushCommand::class],
            ['statuses', StatusCommand::class],
            ['commits', CommitCommand::class],
            ['stashes', StashCommand::class],
            ['config', ConfigCommand::class],
            ['remotes', RemoteCommand::class],
            ['ignores', IgnoreCommand::class],
            ['pulls', PullCommand::class],
            ['files', FileCommand::class],
            ['archives', ArchiveCommand::class],
            ['transaction', ArchiveTransaction::class],
            ['garbage', GarbageCommand::class],
            ['merges', MergeCommand::class],
            ['attributes', AttributeCommand::class],
            ['submodules', SubmoduleCommand::class],
            ['backup', Backup::class],
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
     * @covers \ArtARTs36\GitHandler\Git::setup
     * @covers \ArtARTs36\GitHandler\Git::branches
     * @covers \ArtARTs36\GitHandler\Git::index
     * @covers \ArtARTs36\GitHandler\Git::pushes
     * @covers \ArtARTs36\GitHandler\Git::statuses
     * @covers \ArtARTs36\GitHandler\Git::commits
     * @covers \ArtARTs36\GitHandler\Git::stashes
     * @covers \ArtARTs36\GitHandler\Git::config
     * @covers \ArtARTs36\GitHandler\Git::remotes
     * @covers \ArtARTs36\GitHandler\Git::ignores
     * @covers \ArtARTs36\GitHandler\Git::pulls
     * @covers \ArtARTs36\GitHandler\Git::files
     * @covers \ArtARTs36\GitHandler\Git::archives
     * @covers \ArtARTs36\GitHandler\Git::transaction
     * @covers \ArtARTs36\GitHandler\Git::garbage
     * @covers \ArtARTs36\GitHandler\Git::merges
     * @covers \ArtARTs36\GitHandler\Git::attributes
     * @covers \ArtARTs36\GitHandler\Git::submodules
     * @covers \ArtARTs36\GitHandler\Git::backup
     * @covers \ArtARTs36\GitHandler\Git::createBackupElements
     * @covers \ArtARTs36\GitHandler\Git::createSubjectsConfigurators
     */
    public function testFactoryMethod(string $method, string $expectedClass): void
    {
        self::assertInstanceOf($expectedClass, $this->callMethodFromObject($this->mockGitHandler, $method));
    }
}
