<?php

namespace ArtARTs36\GitHandler\Tests;

use ArtARTs36\GitHandler\Support\Str;
use PHPUnit\Framework\TestCase;

/**
 * Class StrTest
 * @package ArtARTs36\HostReviewerCore\Tests\Unit
 */
final class StrTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Support\Str::contains
     */
    public function testContains(): void
    {
        $haystack = "Artem Ukrainskiy";

        self::assertTrue(Str::contains($haystack, 'Artem'));
        self::assertTrue(Str::contains($haystack, 'artem'));
        self::assertTrue(Str::contains($haystack, 'rtem'));
        self::assertFalse(Str::contains($haystack, 'aartem'));
    }
}
