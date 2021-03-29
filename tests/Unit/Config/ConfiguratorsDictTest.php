<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Config;

use ArtARTs36\GitHandler\Config\ConfiguratorsDict;
use ArtARTs36\GitHandler\Contracts\ConfigSubject;
use ArtARTs36\GitHandler\Contracts\SubjectConfigurator;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class ConfiguratorsDictTest extends TestCase
{
    public function testMake(): void
    {
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
        ]);

        $given = $dict->getIterator()->getArrayCopy();

        self::assertEquals([
            'test1' => $one,
            'test2' => $two,
        ], $given);
    }
}
