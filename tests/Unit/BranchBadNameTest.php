<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Support\BranchBadName;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;
use ArtARTs36\Str\Str;

class BranchBadNameTest extends TestCase
{
    public function dataIsProvider(): array
    {
        return [
            ['HEAD', true],
            ['frfre...erfre', true],
            ['branch[fewew', true],
            ['dev', false],
        ];
    }

    /**
     * @dataProvider dataIsProvider
     * @covers \ArtARTs36\GitHandler\Support\BranchBadName::is
     */
    public function testIs(string $branch, bool $condition): void
    {
        self::assertSame($condition, BranchBadName::is(Str::make($branch)));
    }
}
