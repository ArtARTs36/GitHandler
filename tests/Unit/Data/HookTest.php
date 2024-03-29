<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Data;

use ArtARTs36\GitHandler\Data\Hook;
use ArtARTs36\GitHandler\Enum\HookName;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class HookTest extends TestCase
{
    public function providerForTestIsSample(): array
    {
        return [
            [
                HookName::UPDATE,
                false,
            ],
            [
                HookName::UPDATE . '.sample',
                true,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\GitHandler\Data\Hook::isSample
     * @covers \ArtARTs36\GitHandler\Data\Hook::__construct
     * @dataProvider providerForTestIsSample
     */
    public function testIsSample(string $name, bool $result): void
    {
        self::assertEquals($result, (new Hook($name, 'ss', new \DateTime()))->isSample());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Data\Hook::now
     */
    public function testNow(): void
    {
        $before = new \DateTime();

        $hook = Hook::now('', '');

        self::assertGreaterThan($before, $hook->lastUpdateDate);
    }
}
