<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Data;

use ArtARTs36\GitHandler\Data\Author;
use ArtARTs36\GitHandler\Data\Log;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class LogTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Data\Log::getAbbreviatedCommitHash
     */
    public function testGetAbbreviatedCommitHash(): void
    {
        $log = new Log(
            '7bfab23737fad677905ae7ddd3ac76e2e31f30a4',
            new \DateTime(),
            new Author('', ''),
            ''
        );

        self::assertEquals('7bfab2', $log->getAbbreviatedCommitHash());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Data\Log::equalsDate
     */
    public function testEqualsDate(): void
    {
        $log = new Log(
            '',
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
