<?php

namespace ArtARTs36\GitHandler\Tests\Origin;

use ArtARTs36\GitHandler\Contracts\OriginUrl;
use ArtARTs36\GitHandler\Exceptions\OriginUrlNotFound;
use ArtARTs36\GitHandler\Origin\Url\AbstractOriginUrl;
use ArtARTs36\GitHandler\Origin\Url\GithubOriginUrl;
use ArtARTs36\GitHandler\Origin\Url\GitlabOriginUrl;
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

    /**
     * @covers \ArtARTs36\GitHandler\Origin\Url\OriginUrlSelector::select
     */
    public function testSelect(): void
    {
        $selector = new OriginUrlSelector([
            'github.com' => $url = new GithubOriginUrl(),
            'gitlab.com' => new GitlabOriginUrl(),
        ]);

        //

        $git = $this->mockHasRemotes('https://github.com/repo/');

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

    protected function makeOriginUrl(array $domains): OriginUrl
    {
        return new class($domains) extends AbstractOriginUrl {
            public function toArchiveFromFetchUrl(string $fetchUrl, string $branch = 'master'): string
            {
                return '';
            }

            public function toCommitFromFetchUrl(string $fetchUrl, string $hash): string
            {
                return '';
            }
        };
    }
}
