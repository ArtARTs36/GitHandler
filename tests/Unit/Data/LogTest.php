<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Data;

use ArtARTs36\GitHandler\Data\Author;
use ArtARTs36\GitHandler\Data\Commit;
use ArtARTs36\GitHandler\Data\Log;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class LogTest extends TestCase
{
    public function providerForTestEqualsDate(): array
    {
        return [
            [$date = new \DateTime(), $date, true],
            [new \DateTime(), new \DateTime('50 day ago'), false],
        ];
    }

    /**
     * @dataProvider providerForTestEqualsDate
     * @covers \ArtARTs36\GitHandler\Data\Log::equalsDate
     * @covers \ArtARTs36\GitHandler\Data\Log::__construct
     */
    public function testEqualsDate(\DateTimeInterface $logDate, \DateTimeInterface $compared, bool $expected): void
    {
        $log = new Log(new Commit(''), $logDate, new Author('', ''), '');

        self::assertEquals($expected, $log->equalsDate($compared));
    }
}
