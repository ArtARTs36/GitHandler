<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Config;

use ArtARTs36\GitHandler\Config\Configurators\PackConfigurator;
use ArtARTs36\GitHandler\Config\Subjects\Pack;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class PackConfiguratorTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Config\Configurators\PackConfigurator::parse
     */
    public function testParse(): void
    {
        $configurator = new PackConfigurator();

        /** @var Pack $pack */
        $pack = $configurator->parse([]);

        self::assertInstanceOf(Pack::class, $pack);
        self::assertEquals('', $pack->windowMemory);
        self::assertEquals('', $pack->packSizeLimit);
        self::assertEquals(0, $pack->threads);
        self::assertEquals('', $pack->deltaCacheSize);
        self::assertEquals('', $pack->sizeLimit);
        self::assertEquals(0, $pack->window);
    }
}
