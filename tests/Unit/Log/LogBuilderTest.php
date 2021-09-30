<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Log;

use ArtARTs36\GitHandler\Support\LogBuilder;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class LogBuilderTest extends TestCase
{
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
