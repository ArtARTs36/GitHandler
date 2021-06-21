<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Exceptions;

use ArtARTs36\GitHandler\Exceptions\BranchDoesNotHaveCommits;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class BranchDoesNotHaveCommitsTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Exceptions\BranchHasNoUpstream::__construct
     * @covers \ArtARTs36\GitHandler\Exceptions\BranchHasNoUpstream::getMessage
     */
    public function testConstructor(): void
    {
        $exception = new BranchDoesNotHaveCommits('master');

        self::assertEquals('master', $exception->errorBranch);
        self::assertEquals("branch 'master' does not have any commits yet", $exception->getMessage());
    }
}
