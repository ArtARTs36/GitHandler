<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Exceptions;

use ArtARTs36\GitHandler\Exceptions\MergeHeadMissing;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class MergeHeadMissingTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Exceptions\MergeHeadMissing::__construct
     * @covers \ArtARTs36\GitHandler\Exceptions\MergeHeadMissing::getMessage
     */
    public function testMessage(): void
    {
        $exception = new MergeHeadMissing();

        self::assertEquals('fatal: There is no merge to abort (MERGE_HEAD missing)', $exception->getMessage());
    }
}
