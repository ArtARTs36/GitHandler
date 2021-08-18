<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Factory;

use ArtARTs36\GitHandler\Factory\LocalGitFactory;
use ArtARTs36\GitHandler\Git;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class LocalGitFactoryTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Factory\LocalGitFactory::factory
     */
    public function testFactory(): void
    {
        self::assertInstanceOf(Git::class, $this->makeLocalGitFactory()->factory(__DIR__));
    }

    private function makeLocalGitFactory(): LocalGitFactory
    {
        return new LocalGitFactory();
    }
}
