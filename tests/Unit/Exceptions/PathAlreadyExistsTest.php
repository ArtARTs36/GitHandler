<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Exceptions;

use ArtARTs36\GitHandler\Exceptions\PathAlreadyExists;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;
use ArtARTs36\Str\Str;

class PathAlreadyExistsTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Exceptions\PathAlreadyExists::__construct
     */
    public function testConstructor(): void
    {
        $exception = new PathAlreadyExists('/path/to/file');

        self::assertEquals('/path/to/file', $exception->errorPath);
        self::assertEquals("Path '/path/to/file' already exists", $exception->getMessage());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Exceptions\PathAlreadyExists::handleIfSo
     */
    public function testHandleIfSo(): void
    {
        PathAlreadyExists::handleIfSo('/path/to/file', Str::fromEmpty());

        self::expectException(PathAlreadyExists::class);

        PathAlreadyExists::handleIfSo(
            '/path/to/file',
            Str::make("destination path '/path/to/file' already exists")
        );
    }
}
