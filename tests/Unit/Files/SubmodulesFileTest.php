<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Files;

use ArtARTs36\GitHandler\Files\SubmodulesFile;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class SubmodulesFileTest extends TestCase
{
    public function providerForTestBuildMap(): array
    {
        return [
            [
            '[submodule "str"]
	path = str
	url = https://github.com/ArtARTs36/str',
                'str',
            [
                'name' => 'str',
                'path' => 'str',
                'url' => 'https://github.com/ArtARTs36/str',
            ],
            ],
        ];
    }

    /**
     * @dataProvider providerForTestBuildMap
     * @covers \ArtARTs36\GitHandler\Files\SubmodulesFile::buildMap
     * @covers \ArtARTs36\GitHandler\Data\Submodule::fromArray
     */
    public function testBuildMap(string $content, string $key, array $expected): void
    {
        $file = $this->makeSubmodulesFile();

        self::assertEquals($expected, $file->buildMap($content)[$key]->toArray());
    }

    private function makeSubmodulesFile(): SubmodulesFile
    {
        return new SubmodulesFile();
    }
}
