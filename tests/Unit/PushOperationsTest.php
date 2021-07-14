<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Exceptions\BranchHasNoUpstream;
use ArtARTs36\GitHandler\Exceptions\UnexpectedException;

class PushOperationsTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Git::push
     */
    public function testPushBranchHasNoUpstreamBranch(): void
    {
        $git = $this->mockGit("fatal: The current branch push-testing has no upstream branch.
To push the current branch and set the remote as upstream, use

    git push --set-upstream origin push-testing
");

        self::expectException(BranchHasNoUpstream::class);

        $git->push();
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::push
     */
    public function testPushGood(): void
    {
        self::assertTrue($this->mockGit('Everything up-to-date')->push(false, 'push-testing'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::push
     */
    public function testOnNullCommandResult(): void
    {
        self::expectException(UnexpectedException::class);

        $this->mockGit(null)->push(true);
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::push
     */
    public function testOnEmptyCommandResult(): void
    {
        self::expectException(UnexpectedException::class);

        $this->mockGit('')->push();
    }

    /**
     * @covers \ArtARTs36\GitHandler\Git::pushOnAutoSetUpStream
     */
    public function testPushOnAutoSetUpStream(): void
    {
        $git = $this->mockGit([
            'dev',
            'Everything up-to-date',
        ]);

        self::assertTrue($git->pushOnAutoSetUpStream());
    }
}
