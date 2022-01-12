<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Data\Author;

use ArtARTs36\GitHandler\Data\Author\CacheableHydrator;
use ArtARTs36\GitHandler\Data\Author\Hydrator;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class CacheableHydratorTest extends TestCase
{
    public function providerForTestHydrate(): array
    {
        return [
            [
                [
                    ['name' => 'ArtARTs36', 'email' => 'temicska99@mail.ru'],
                    ['name' => 'ArtARTs36', 'email' => 'temicska99@mail.ru'],
                ]
            ],
            [
                [
                    ['name' => 'ArtARTs36', 'email' => 'temicska99@mail.ru'],
                    ['name' => 'random-name', 'email' => 'temicska99@mail.ru'],
                ],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\GitHandler\Data\Author\CacheableHydrator::hydrate
     * @dataProvider providerForTestHydrate
     */
    public function testHydrate(array $raws): void
    {
        $hydrator = new CacheableHydrator(new Hydrator());

        [$firstAuthor, $twoAuthor] = [$hydrator->hydrate($raws[0]), $hydrator->hydrate($raws[1])];

        self::assertSame($firstAuthor, $twoAuthor);
    }
}
