<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Data\Author;

use ArtARTs36\GitHandler\Data\Author\Hydrator;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class HydratorTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Data\Author\Hydrator::hydrate
     */
    public function testHydrate(): void
    {
        $raw = [
            'name' => 'ArtARTs36',
            'email' => 'temicska99@mail.ru',
        ];

        self::assertEquals($raw, (new Hydrator())->hydrate($raw)->toArray());
    }
}
