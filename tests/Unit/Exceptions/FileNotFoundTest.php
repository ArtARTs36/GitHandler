<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Exceptions;

use ArtARTs36\GitHandler\Exceptions\FileNotFound;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;
use ArtARTs36\Str\Str;

class FileNotFoundTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Exceptions\FileNotFound::__construct
     */
    public function testConstructor(): void
    {
        $exception = new FileNotFound('file.php');

        self::assertEquals("File 'file.php' Not Found", $exception->getMessage());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Exceptions\FileNotFound::handleIfSo
     */
    public function testHandleIfSo(): void
    {
        FileNotFound::handleIfSo(Str::make('f.php'));

        self::expectException(FileNotFound::class);

        FileNotFound::handleIfSo(Str::make("pathspec 'f.php' did not match any"));
    }
}
