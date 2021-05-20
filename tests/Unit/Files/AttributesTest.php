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

        $expected = "\npattern1\t\tattr\npattern2\t\tattr";

        self::assertEquals($expected, $this->callMethodFromObject(
            $attributes,
            'wraps',
            ['pattern1', 'pattern2'],
            'attr'
        ));
    }
}
