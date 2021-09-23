<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Exceptions;

use ArtARTs36\GitHandler\Exceptions\ConfigVariableNotFound;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class ConfigVariableNotFoundTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Exceptions\ConfigVariableNotFound::__construct
     */
    public function testConstructor(): void
    {
        $exception = new ConfigVariableNotFound('test-key');

        self::assertEquals('key does not contain a section: test-key', $exception->getMessage());
    }
}
