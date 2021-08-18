<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Data;

use ArtARTs36\GitHandler\Data\GitContext;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class GitContextTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Data\GitContext::make
     */
    public function testMakeOnOneParameter(): void
    {
        $context = GitContext::make(__DIR__);

        self::assertEquals([
            'rootDir' => __DIR__,
            'gitDir'  => __DIR__ . '/.git'
        ], $context->toArray());
    }
}
