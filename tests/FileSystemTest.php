<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Support\FileSystem;
use PHPUnit\Framework\TestCase;

/**
 * Class FileSystemTest
 * @package ArtARTs36\HostReviewerCore\Tests\Unit
 */
class FileSystemTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Support\FileSystem::belowPath
     */
    public function testBelowPath(): void
    {
        $expected = realpath(__DIR__ . '/..');

        self::assertEquals($expected, FileSystem::belowPath(__DIR__));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Support\FileSystem::endFolder
     */
    public function testEndFolder(): void
    {
        self::assertEquals('tests', FileSystem::endFolder(__DIR__));
        self::assertEquals('tests', FileSystem::endFolder(__FILE__));

        self::assertEquals('tests', FileSystem::endFolder('/path/to/tests'));
        self::assertEquals('tests', FileSystem::endFolder('/path/to/tests/image.jpeg'));
        self::assertEquals('', FileSystem::endFolder('image.jpeg'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Support\FileSystem::isPseudoFile
     */
    public function testIsPseudoFile(): void
    {
        self::assertFalse(FileSystem::isPseudoFile('image'));
        self::assertTrue(FileSystem::isPseudoFile('image.jpeg'));
        self::assertTrue(FileSystem::isPseudoFile('super.image.jpeg'));
    }
}
