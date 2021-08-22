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
                'export-ignore',
                true,
            ],
            [
                ['file.txt', ['export-ignore']],
                'export-ignor',
                false,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestHas
     * @covers \ArtARTs36\GitHandler\Data\GitAttributes::has
     * @covers \ArtARTs36\GitHandler\Data\GitAttributes::__construct
     */
    public function testHas(array $attributesData, string $attr, bool $state): void
    {
        $attribute = new GitAttributes(...$attributesData);

        self::assertEquals($state, $attribute->has($attr));
    }
}
