<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Making;

use ArtARTs36\GitHandler\Making\MakingPush;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;

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
     * @covers \ArtARTs36\GitHandler\Making\MakingPush::onCurrentBranchHead
     */
    public function testOnCurrentBranchHead(): void
    {
        $push = $this->createMakingPush();

        $push->onCurrentBranchHead();

        self::assertEquals('HEAD', self::getPropertyValueOfObject($push, 'branch'));
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

    /**
     * @covers \ArtARTs36\GitHandler\Making\MakingPush::onRemote
     */
    public function testOnRemote(): void
    {
        $push = $this->createMakingPush();

        $push->onRemote(function (UriInterface $uri) {
            return $uri->withHost('site.ru');
        });

        self::assertEquals('site.ru', $this->getPropertyValueOfObject($push, 'remote')->getHost());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Making\MakingPush::tags
     */
    public function testTags(): void
    {
        $push = $this->createMakingPush();

        $push->tags();

        self::assertTrue($this->getPropertyValueOfObject($push, 'tags'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Making\MakingPush::onSetUpStream
     */
    public function onSetUpStream(): void
    {
        $push = $this->createMakingPush();

        $push->onSetUpStream();

        self::assertTrue($this->getPropertyValueOfObject($push, 'setUpStream'));
    }

    private function createMakingPush(): MakingPush
    {
        return new MakingPush(new Uri());
    }
}
