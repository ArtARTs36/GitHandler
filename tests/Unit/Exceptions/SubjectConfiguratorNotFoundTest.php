<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Exceptions;

use ArtARTs36\GitHandler\Exceptions\SubjectConfiguratorNotFound;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class SubjectConfiguratorNotFoundTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Exceptions\SubjectConfiguratorNotFound::__construct
     */
    public function testConstructor(): void
    {
        self::assertSame(
            "Subject Configurator by prefix test not found",
            (new SubjectConfiguratorNotFound('test'))->getMessage()
        );
    }
}
