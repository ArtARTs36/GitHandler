<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Config;

use ArtARTs36\GitHandler\Config\Mapper\ConfigKeyPropertyMapper;
use ArtARTs36\GitHandler\Tests\Unit\Config\Prototypes\Car;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class ConfigKeyPropertyMapperTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Config\Mapper\ConfigKeyPropertyMapper::createObjectFromArray
     * @covers \ArtARTs36\GitHandler\Config\Mapper\ConfigKeyPropertyMapper::map
     * @covers \ArtARTs36\GitHandler\Config\Mapper\ConfigKeyPropertyMapper::make
     * @covers \ArtARTs36\GitHandler\Config\Mapper\ConfigKeyPropertyMapper::__construct
     */
    public function testCreateObjectFromArray(): void
    {
        $mapper = ConfigKeyPropertyMapper::make();

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
