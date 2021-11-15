<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Commands;

use ArtARTs36\GitHandler\Command\Commands\BranchCommand;
use ArtARTs36\GitHandler\Command\Commands\PushCommand;
use ArtARTs36\GitHandler\Command\Commands\RemoteCommand;
use ArtARTs36\GitHandler\Exceptions\BranchHasNoUpstream;
use ArtARTs36\GitHandler\Exceptions\UnexpectedException;
use ArtARTs36\GitHandler\Tests\Unit\GitTestCase;

final class PushCommandTest extends GitTestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\PushCommand::push
     * @covers \ArtARTs36\GitHandler\Command\Commands\PushCommand::buildPushCommand
     */
    public function testPushBranchHasNoUpstreamBranch(): void
    {
        $this->mockCommandExecutor->nextFailed("fatal: The current branch push-testing has no upstream branch.
To push the current branch and set the remote as upstream, use

    git push --set-upstream origin push-testing
");
        self::expectException(BranchHasNoUpstream::class);

        $this->makePushCommand()->push();
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\PushCommand::push
     * @covers \ArtARTs36\GitHandler\Command\Commands\PushCommand::buildPushCommand
     */
    public function testPushGood(): void
    {
        $this->mockCommandExecutor->nextOk('Everything up-to-date');

        self::assertTrue($this->makePushCommand()->push(true, 'push-testing'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\PushCommand::pushOnAutoSetUpStream
     * @covers \ArtARTs36\GitHandler\Command\Commands\PushCommand::push
     * @covers \ArtARTs36\GitHandler\Command\Commands\PushCommand::buildPushCommand
     */
    public function testPushOnAutoSetUpStream(): void
    {
        $this->mockCommandExecutor->nextOk('dev')->nextOk('Everything up-to-date');

        self::assertTrue($this->makePushCommand()->pushOnAutoSetUpStream());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Command\Commands\PushCommand::pushOnAutoSetUpStream
     */
    public function testPushOnAutoSetUpStreamWithInvalidCurrentBranch(): void
    {
        $this->mockCommandExecutor->nextOk('HEAD')->nextOk('Everything up-to-date');

        self::assertTrue($this->makePushCommand()->pushOnAutoSetUpStream());
    }

    public function providerForTestPushAllTags(): array
    {
        return [
            [
                '[new tag]         0.1.3 -> 0.1.3', // result
                true, // expected
            ],
            [
                '',
                false,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestPushAllTags
     * @covers \ArtARTs36\GitHandler\Command\Commands\PushCommand::pushAllTags
     * @covers \ArtARTs36\GitHandler\Command\Commands\PushCommand::buildPushCommand
     * @covers \ArtARTs36\GitHandler\Command\Commands\PushCommand::pushWithOption
     */
    public function testPushAllTags(string $stderr, bool $expected): void
    {
        $this->mockCommandExecutor->nextOk('', $stderr);

        self::assertEquals($expected, $this->makePushCommand()->pushAllTags());
    }

    private function makePushCommand(): PushCommand
    {
        return new PushCommand(
            new BranchCommand($this->mockCommandBuilder, $this->mockCommandExecutor),
            $this->mockCommandBuilder,
            $this->mockCommandExecutor,
            new RemoteCommand($this->mockCommandBuilder, $this->mockCommandExecutor)
        );
    }
}
