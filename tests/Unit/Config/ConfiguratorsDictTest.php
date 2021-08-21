<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Config;

use ArtARTs36\GitHandler\Config\ConfiguratorsDict;
use ArtARTs36\GitHandler\Contracts\Config\ConfigSubject;
use ArtARTs36\GitHandler\Contracts\Config\SubjectConfigurator;
use ArtARTs36\GitHandler\Exceptions\SubjectConfiguratorNotFound;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class ConfiguratorsDictTest extends TestCase
{
    public function mockDataProvider(): array
    {
        return [
            [
                ConfiguratorsDict::make([
                    $one = $this->mockConfigurator('test1'),
                    $two = $this->mockConfigurator('test2'),
                ]),
                $one,
                $two,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\GitHandler\Config\ConfiguratorsDict::getIterator
     * @dataProvider mockDataProvider
     */
    public function testGetIterator(ConfiguratorsDict $dict, SubjectConfigurator $one, SubjectConfigurator $two): void
    {
        $given = $dict->getIterator()->getArrayCopy();

        self::assertEquals([
            'test1' => $one,
            'test2' => $two,
        ], $given);
    }

    /**
     * @covers \ArtARTs36\GitHandler\Config\ConfiguratorsDict::has
     * @dataProvider mockDataProvider
     */
    public function testHas(ConfiguratorsDict $dict, SubjectConfigurator $one, SubjectConfigurator $two): void
    {
        self::assertTrue($dict->has($one->getPrefix()));
        self::assertTrue($dict->has($two->getPrefix()));
        self::assertFalse($dict->has('random'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Config\ConfiguratorsDict::getOrFail
     * @dataProvider mockDataProvider
     */
    public function testGetOrFail(ConfiguratorsDict $dict, SubjectConfigurator $one, SubjectConfigurator $two): void
    {
        self::assertSame($one, $dict->getOrFail($one->getPrefix()));
        self::assertSame($two, $dict->getOrFail($two->getPrefix()));

        self::expectException(SubjectConfiguratorNotFound::class);
        $dict->getOrFail('random');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Config\ConfiguratorsDict::make
     */
    public function testMake(): void
    {
        $data = [
            $a = $this->mockConfigurator('a'),
            $b = $this->mockConfigurator('b'),
        ];

        $dict = ConfiguratorsDict::make($data);

        self::assertEquals(
            compact('a', 'b'),
            $this->getPropertyValueOfObject($dict, 'configurators')
        );
    }

    protected function mockConfigurator(string $prefix): SubjectConfigurator
    {
        return new class($prefix) implements SubjectConfigurator {
            private $prefix;

            public function __construct(string $prefix)
            {
                $this->prefix = $prefix;
            }

            public function parse(array $raw): ConfigSubject
            {
                //
            }

            public function getPrefix(): string
            {
                return $this->prefix;
            }
        };
    }
}
