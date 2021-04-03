<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Exceptions;

use ArtARTs36\GitHandler\Exceptions\BranchNotFound;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class BranchNotFoundTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Exceptions\BranchNotFound::__construct
     */
    public function testConstructor(): void
    {
        $e = new BranchNotFound('master');

        self::assertEquals('master', $e->errorBranch);
    }
}
