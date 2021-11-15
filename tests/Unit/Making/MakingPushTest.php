<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Making;

use ArtARTs36\GitHandler\Making\MakingPush;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;
use GuzzleHttp\Psr7\Uri;

final class MakingPushTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Making\MakingPush::onBranch
     */
    public function testOnBranch(): void
    {
        $push = $this->createMakingPush();

        $push->onBranch('dev');

        self::assertEquals('dev', $this->getPropertyValueOfObject($push, 'branch'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Making\MakingPush::force
     */
    public function testForce(): void
    {
        $push = $this->createMakingPush();

        $push->force();

        self::assertTrue($this->getPropertyValueOfObject($push, 'isForce'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Making\MakingPush::onBranchHead
     */
    public function testOnBranchHead(): void
    {
        $push = $this->createMakingPush();

        $push->onBranchHead('tested');

        self::assertEquals('HEAD:tested', $this->getPropertyValueOfObject($push, 'branch'));
    }

    private function createMakingPush(): MakingPush
    {
        return new MakingPush(new Uri());
    }
}
