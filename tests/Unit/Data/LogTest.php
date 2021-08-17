<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Data;

use ArtARTs36\GitHandler\Data\Author;
use ArtARTs36\GitHandler\Data\Commit;
use ArtARTs36\GitHandler\Data\Log;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class LogTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Data\Log::equalsDate
     */
    public function testEqualsDate(): void
    {
        $log = new Log(
            new Commit(''),
            $date = new \DateTime(),
            new Author('', ''),
            ''
        );

        //

        self::assertTrue($log->equalsDate($date));

        //

        self::assertFalse($log->equalsDate(new \DateTime('50 day ago')));
    }
}
