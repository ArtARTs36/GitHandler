<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Data;

use ArtARTs36\GitHandler\Data\GitAttributes;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class GitAttributesTest extends TestCase
{
    public function providerForTestHas(): array
    {
        return [
            [
                ['file.txt', ['export-ignore']],
                ['export-ignore'],
            ],
        ];
    }

    /**
     * @dataProvider providerForTestHas
     * @covers \ArtARTs36\GitHandler\Data\GitAttributes::has
     */
    public function testHas(array $attributesData, array $expected): void
    {
        $attribute = new GitAttributes(...$attributesData);

        self::assertEquals($expected, $attribute->attributes);
    }
}
