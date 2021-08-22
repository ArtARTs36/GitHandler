<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Data;

use ArtARTs36\GitHandler\Data\FileMatch;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class FileMatchTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Data\FileMatch::fromArray
     * @covers \ArtARTs36\GitHandler\Data\FileMatch::__construct
     */
    public function testFromArray(): void
    {
        $match = FileMatch::fromArray($expected = [
            'file' => 'test.php',
            'line' => 23,
            'content' => 'abc',
        ]);

        self::assertEquals($expected, $match->toArray());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Data\FileMatch::getReference
     * @covers \ArtARTs36\GitHandler\Data\FileMatch::__construct
     */
    public function testGetReference(): void
    {
        $match = FileMatch::fromArray([
            'file' => 'file.php',
            'line' => 9,
            'content' => '1234',
        ]);

        self::assertEquals('file.php:9', $match->getReference());
    }
}
