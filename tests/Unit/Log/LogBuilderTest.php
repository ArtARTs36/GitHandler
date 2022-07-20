<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Log;

use ArtARTs36\GitHandler\Support\LogBuilder;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class LogBuilderTest extends TestCase
{
    public function providerForTestSetOptionValue(): array
    {
        return [
            [
                'offset',
                10,
                [
                    'skip' => [10],
                ],
            ],
            [
                'limit',
                10,
                [
                    'max-count' => [10],
                ],
            ],
            [
                'before',
                new \DateTime('2021-09-29 18:00:00'),
                [
                    'before' => ['2021-09-29 18:00:00'],
                ],
            ],
            [
                'after',
                new \DateTime('2021-09-29 18:00:00'),
                [
                    'after' => ['2021-09-29 18:00:00'],
                ],
            ],
        ];
    }

    /**
     * @dataProvider providerForTestSetOptionValue
     * @covers \ArtARTs36\GitHandler\Support\LogBuilder::offset
     * @covers \ArtARTs36\GitHandler\Support\LogBuilder::limit
     * @covers \ArtARTs36\GitHandler\Support\LogBuilder::setOptionValue
     * @covers \ArtARTs36\GitHandler\Support\LogBuilder::before
     * @covers \ArtARTs36\GitHandler\Support\LogBuilder::after
     * @covers \ArtARTs36\GitHandler\Support\LogBuilder::setOptionValueDate
     */
    public function testSetOptionValue(string $method, $value, array $expected)
    {
        $builder = $this->makeLogBuilder();

        $this->callMethodFromObject($builder, $method, $value);

        self::assertEquals(
            $expected,
            /** @see LogBuilder::$optionValues */
            $this->getPropertyValueOfObject($builder, 'optionValues')
        );
    }

    /**
     * @covers \ArtARTs36\GitHandler\Support\LogBuilder::union
     */
    public function testUnion(): void
    {
        $builder = $this->makeLogBuilder();

        $builder->union($expected = function (LogBuilder $builder) {
        });

        self::assertEquals($expected, $this->getPropertyValueOfObject($builder, 'unions')[0][0]);
    }

    private function makeLogBuilder(): LogBuilder
    {
        return new LogBuilder();
    }
}
