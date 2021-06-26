<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Config;

use ArtARTs36\GitHandler\Config\Subjects\AbstractSubject;
use ArtARTs36\GitHandler\Contracts\ConfigSubject;
use ArtARTs36\GitHandler\Contracts\SubjectConfigurator;
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

    /**
     * @covers \ArtARTs36\GitHandler\Config\RegexConfigResultParser::parseByPrefix
     */
    public function testParseByPrefix(): void
    {
        $parser = GitSimpleFactory::factoryConfigReader([
            new class implements SubjectConfigurator {

                public function parse(array $raw): ConfigSubject
                {
                    return new class($raw['option']) extends AbstractSubject {
                        public $option;

                        public function __construct(int $option)
                        {
                            $this->option = $option;
                        }
                    };
                }

                public function getPrefix(): string
                {
                    return 'task';
                }
            },
        ]);

        $task = $parser->parseByPrefix(Str::make('task.option=1'), 'task');

        self::assertSame(1, $task->option);
    }
}
