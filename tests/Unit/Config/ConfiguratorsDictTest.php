<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Config;

use ArtARTs36\GitHandler\Config\ConfiguratorsDict;
use ArtARTs36\GitHandler\Contracts\ConfigSubject;
use ArtARTs36\GitHandler\Contracts\SubjectConfigurator;
use ArtARTs36\GitHandler\Exceptions\SubjectConfiguratorNotFound;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class ConfiguratorsDictTest extends TestCase
{
    public function mockDataProvider(): array
    {
        return [
            [
                $dict = ConfiguratorsDict::make([
                    $one = new class implements SubjectConfigurator {
                        public function parse(array $raw): ConfigSubject
                        {
                            //
                        }

                        public function getPrefix(): string
                        {
                            return 'test1';
                        }
                    },
                    $two = new class implements SubjectConfigurator {
                        public function parse(array $raw): ConfigSubject
                        {
                            //
                        }

                        public function getPrefix(): string
                        {
                            return 'test2';
                        }
                    },
                ]),
                $one,
                $two,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\GitHandler\Config\ConfiguratorsDict::make
     * @dataProvider mockDataProvider
     */
    public function testMake(ConfiguratorsDict $dict, SubjectConfigurator $one, SubjectConfigurator $two): void
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
}
