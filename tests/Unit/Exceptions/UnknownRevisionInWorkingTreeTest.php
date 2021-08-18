<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Exceptions;

use ArtARTs36\GitHandler\Exceptions\UnknownRevisionInWorkingTree;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class UnknownRevisionInWorkingTreeTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Exceptions\UnknownRevisionInWorkingTree::__construct
     */
    public function testConstruct(): void
    {
        $exception = new UnknownRevisionInWorkingTree('/var/web');

        self::assertEquals([
            'property' => '/var/web',
            'message'  => '/var/web: unknown revision or path not in the working tree.'
        ], [
            'property' => $exception->failedRevisionOrPath,
            'message'  => $exception->getMessage(),
        ]);
    }
}
