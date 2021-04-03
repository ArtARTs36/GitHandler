<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Exceptions;

use ArtARTs36\GitHandler\Exceptions\BranchAlreadyExists;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class BranchAlreadyExistsTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Exceptions\BranchAlreadyExists::__construct
     */
    public function testConstructor(): void
    {
        $e = new BranchAlreadyExists('master');

        self::assertEquals('master', $e->errorBranch);
    }
}
