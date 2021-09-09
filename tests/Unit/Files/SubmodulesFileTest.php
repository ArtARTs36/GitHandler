<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Files;

use ArtARTs36\GitHandler\Data\Submodule;
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

    public function providerForTestBuildContent(): array
    {
        return [
            [
                [new Submodule('str', 'str', 'site.ru')],
                '[submodule "str"]
	path = str
	url = site.ru',
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

    /**
     * @dataProvider providerForTestBuildContent
     * @covers \ArtARTs36\GitHandler\Files\SubmodulesFile::buildContent
     * @covers \ArtARTs36\GitHandler\Files\SubmodulesFile::buildSubmoduleContent
     */
    public function testBuildContent(array $map, string $expected): void
    {
        self::assertEquals($expected, $this->makeSubmodulesFile()->buildContent($map));
    }

    private function makeSubmodulesFile(): SubmodulesFile
    {
        return new SubmodulesFile();
    }
}
