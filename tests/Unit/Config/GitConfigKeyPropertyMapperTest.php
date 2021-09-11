<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Config;

use ArtARTs36\GitHandler\Config\Mapper\GitConfigKeyPropertyMapper;
use ArtARTs36\GitHandler\Tests\Unit\Config\Prototypes\Car;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class GitConfigKeyPropertyMapperTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Config\Mapper\GitConfigKeyPropertyMapper::createObjectFromArray
     * @covers \ArtARTs36\GitHandler\Config\Mapper\GitConfigKeyPropertyMapper::doMap
     * @covers \ArtARTs36\GitHandler\Config\Mapper\GitConfigKeyPropertyMapper::make
     * @covers \ArtARTs36\GitHandler\Config\Mapper\GitConfigKeyPropertyMapper::__construct
     */
    public function testCreateObjectFromArray(): void
    {
        $mapper = GitConfigKeyPropertyMapper::make();

        $result = $mapper->createObjectFromArray(Car::class, [
            'self_color' => 'red',
            'other_color' => 'black',
        ]);

        self::assertEquals([
            Car::class,
            'red',
        ], [get_class($result), $result->color]);
    }
}
