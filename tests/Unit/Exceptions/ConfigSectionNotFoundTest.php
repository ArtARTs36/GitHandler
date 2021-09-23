<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Exceptions;

use ArtARTs36\GitHandler\Exceptions\ConfigSectionNotFound;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class ConfigSectionNotFoundTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Exceptions\ConfigSectionNotFound::__construct
     */
    public function testConstructor(): void
    {
        $exception = new ConfigSectionNotFound('test');

        self::assertEquals('Key does not contain a section: test', $exception->getMessage());
    }
}
