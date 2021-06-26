<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Config;

use ArtARTs36\GitHandler\Exceptions\ConfigDataNotFound;
use ArtARTs36\GitHandler\GitSimpleFactory;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;
use ArtARTs36\Str\Str;

class RegexConfigResultParserTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Config\RegexConfigResultParser::grouped
     */
    public function testGrouped(): void
    {
        $parser = GitSimpleFactory::factoryConfigReader();

        $matches = [
            [
                null,
                'scope1',
                'field1',
                'value1',
            ],
            [
                null,
                'scope1',
                'field2',
                'value2',
            ],
            [
                null,
                'scope2',
                'field3',
                'value3',
            ],
        ];

        $expected = [
            'scope1' => [
                'field1' => 'value1',
                'field2' => 'value2',
            ],
            'scope2' => [
                'field3' => 'value3',
            ],
        ];

        self::assertEquals($expected, $this->callMethodFromObject($parser, 'grouped', $matches));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Config\RegexConfigResultParser::parseByPrefix
     */
    public function testParseByPrefixOnNotFound(): void
    {
        $parser = GitSimpleFactory::factoryConfigReader();

        self::expectException(ConfigDataNotFound::class);

        $parser->parseByPrefix(Str::make(''), 'test');
    }
}
