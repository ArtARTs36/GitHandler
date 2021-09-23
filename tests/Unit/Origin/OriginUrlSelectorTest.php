<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Origin;

use ArtARTs36\GitHandler\Contracts\Origin\OriginUrlBuilder;
use ArtARTs36\GitHandler\Exceptions\OriginUrlNotFound;
use ArtARTs36\GitHandler\Origin\Url\AbstractOriginUrlBuilder;
use ArtARTs36\GitHandler\Origin\Url\GithubOriginUrlBuilder;
use ArtARTs36\GitHandler\Origin\Url\GitlabOriginUrlBuilder;
use ArtARTs36\GitHandler\Origin\Url\OriginUrlSelector;
use ArtARTs36\GitHandler\Tests\Support\MockHasRemotes;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class OriginUrlSelectorTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Origin\Url\OriginUrlSelector::has
     */
    public function testHas(): void
    {
        $selector = new OriginUrlSelector([
            'domain.ru' => new GithubOriginUrlBuilder(),
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
            'domain.ru' => $url = new GithubOriginUrlBuilder(),
        ]);

        //

        self::assertSame($url, $selector->selectByDomain('domain.ru'));

        //

        self::expectException(OriginUrlNotFound::class);

        $selector->selectByDomain('');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Origin\Url\OriginUrlSelector::select
     * @covers \ArtARTs36\GitHandler\Origin\Url\OriginUrlSelector::selectByUrl
     */
    public function testSelect(): void
    {
        $selector = new OriginUrlSelector([
            'github.com' => $url = new GithubOriginUrlBuilder(),
            'gitlab.com' => new GitlabOriginUrlBuilder(),
        ]);

        //

        $git = new MockHasRemotes('https://github.com/repo/');

        self::assertSame($url, $selector->select($git));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Origin\Url\OriginUrlSelector::make
     */
    public function testMake(): void
    {
        [$urlOne, $urlTwo] = $urls = [$this->makeOriginUrl(['site.ru']), $this->makeOriginUrl(['domain.ru'])];

        $selector = OriginUrlSelector::make($urls);

        self::assertSame([
            'site.ru' => $urlOne,
            'domain.ru' => $urlTwo,
        ], $this->getPropertyValueOfObject($selector, 'map'));
    }

    protected function makeOriginUrl(array $domains): OriginUrlBuilder
    {
        return new class($domains) extends AbstractOriginUrlBuilder {
            public function toArchiveFromFetchUrl(string $fetchUrl, string $branch = 'master'): string
            {
                return '';
            }

            public function toCommitFromFetchUrl(string $fetchUrl, string $hash): string
            {
                return '';
            }

            public function toTagFromFetchUrl(string $fetchUrl, string $tag): string
            {
                return '';
            }

            public function toTagsCompareFromFetchUrl(string $fetchUrl, string $oneTag, string $twoTag): string
            {
                return '';
            }
        };
    }
}
