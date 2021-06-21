<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Exceptions;

use ArtARTs36\GitHandler\Exceptions\BranchHasNoUpstream;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class BranchHasNoUpstreamTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Exceptions\BranchHasNoUpstream::__construct
     * @covers \ArtARTs36\GitHandler\Exceptions\BranchHasNoUpstream::prepareMessage
     */
    public function testConstructor(): void
    {
        $exception = new BranchHasNoUpstream('master');

        self::assertEquals('master', $exception->errorBranch);
        self::assertEquals('The current branch master has no upstream branch', $exception->getMessage());
    }
}
