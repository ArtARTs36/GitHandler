<?php

namespace ArtARTs36\GitHandler\Tests\Files;

use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class FilesTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Files\Files::__construct
     * @covers \ArtARTs36\GitHandler\Files\Files::manager
     * @covers \ArtARTs36\GitHandler\Files\Files::attributes
     * @covers \ArtARTs36\GitHandler\Files\Files::ignore
     */
    public function testConstructorAndGetters(): void
    {
        $files = $this->mockGit('')->files();

        $expected = [
            $this->getPropertyValueOfObject($files, 'manager'),
            $this->getPropertyValueOfObject($files, 'attributes'),
            $this->getPropertyValueOfObject($files, 'ignore'),
        ];

        self::assertSame($expected, [
            $files->manager(),
            $files->attributes(),
            $files->ignore(),
        ]);
    }
}
