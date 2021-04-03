<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Exceptions;

use ArtARTs36\GitHandler\Exceptions\ConfigDataNotFound;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class ConfigDataNotFoundTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Exceptions\ConfigDataNotFound::__construct
     */
    public function testConstructor(): void
    {
        $e = new ConfigDataNotFound('test-prefix');

        self::assertEquals('test-prefix', $e->errorPrefix);
    }
}
