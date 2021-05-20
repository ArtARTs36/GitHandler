<?php

namespace ArtARTs36\GitHandler\Tests\Files;

use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class AttributesTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Files\Attributes::wrap
     */
    public function testWrap(): void
    {
        $attributes = $this->mockGit('')->files()->attributes();

        $expected = "pattern\t\tattr";

        self::assertEquals($expected, $this->callMethodFromObject($attributes, 'wrap', 'pattern', 'attr'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Files\Attributes::wraps
     */
    public function testWraps(): void
    {
        $attributes = $this->mockGit('')->files()->attributes();

        $expected = "pattern1\t\tattr\npattern2\t\tattr";

        self::assertEquals($expected, $this->callMethodFromObject(
            $attributes,
            'wraps',
            ['pattern1', 'pattern2'],
            'attr'
        ));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Files\Attributes::add
     */
    public function testAdd(): void
    {
        $attributes = $this->mockGit('')->files()->attributes();

        // Created File

        $attributes->add('export-ignore', ['path1', 'path2']);

        self::assertTrue($this->fileSystem->exists($attributes->getPathToFile()));
        self::assertEquals("path1		export-ignore
path2		export-ignore", $this->fileSystem->getFileContent($attributes->getPathToFile()));

        // Updated File

        $attributes->add('text=auto', ['*']);

        self::assertTrue($this->fileSystem->exists($attributes->getPathToFile()));
        self::assertEquals("path1		export-ignore
path2		export-ignore
*		text=auto", $this->fileSystem->getFileContent($attributes->getPathToFile())->__toString());
    }
}
