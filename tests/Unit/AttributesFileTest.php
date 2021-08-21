<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Attributes\AttributesFile;

final class AttributesFileTest extends TestCase
{
    public function providerTestBuildContent(): array
    {
        return [
            [
                [
                    'file.txt' => ['export-ignore', 'diff=1'],
                    'file2.txt' => ['export-ignore'],
                ],
                "file.txt  export-ignore diff=1\nfile2.txt export-ignore\n",
            ]
        ];
    }

    /**
     * @dataProvider providerTestBuildContent
     * @covers \ArtARTs36\GitHandler\Attributes\AttributesFile::buildContent
     */
    public function testBuildContent(array $map, string $expected): void
    {
        $file = $this->makeAttributesFile();

        self::assertEquals($expected, $file->buildContent($map));
    }

    private function makeAttributesFile(): AttributesFile
    {
        return new AttributesFile();
    }
}
