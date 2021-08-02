<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Config\Subjects;

use ArtARTs36\GitHandler\Config\Subjects\Branch;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class BranchTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Config\Subjects\Branch::fromLinks
     */
    public function testFromLinks(): void
    {
        self::assertEquals([
            'name' => 'master',
            'remote' => 'remote/master',
            'merge' => 'merger/master',
        ], Branch::fromLinks('master', [
            'remote' => 'remote/master',
            'merge' => 'merger/master',
        ])->toArray());
    }
}
