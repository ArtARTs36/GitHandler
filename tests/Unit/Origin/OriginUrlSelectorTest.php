<?php

namespace ArtARTs36\GitHandler\Tests\Origin;

use ArtARTs36\GitHandler\Exceptions\OriginUrlNotFound;
use ArtARTs36\GitHandler\Origin\Url\GithubOriginUrl;
use ArtARTs36\GitHandler\Origin\Url\OriginUrlSelector;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class OriginUrlSelectorTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Origin\Url\OriginUrlSelector::has
     */
    public function testHas(): void
    {
        $selector = new OriginUrlSelector([
            'domain.ru' => new GithubOriginUrl(),
        ]);

        //

        self::assertFalse($selector->has('test.ru'));
        self::assertTrue($selector->has('domain.ru'));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Origin\Url\OriginUrlSelector::selectByDomain
     */
    public function testSelectByDomain(): void
    {
        $selector = new OriginUrlSelector([
            'domain.ru' => $url = new GithubOriginUrl(),
        ]);

        //

        self::assertSame($url, $selector->selectByDomain('domain.ru'));

        //

        self::expectException(OriginUrlNotFound::class);

        $selector->selectByDomain('');
    }
}
