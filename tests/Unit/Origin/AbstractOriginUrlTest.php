<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Origin;

use ArtARTs36\GitHandler\Exceptions\GivenInvalidUri;
use ArtARTs36\GitHandler\Origin\Url\AbstractOriginUrlBuilder;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;
use ArtARTs36\Str\Str;

final class AbstractOriginUrlTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Origin\Url\AbstractOriginUrlBuilder::getAvailableDomains
     * @covers \ArtARTs36\GitHandler\Origin\Url\AbstractOriginUrlBuilder::__construct
     */
    public function testGetAvailableDomains(): void
    {
        $url = $this->mock();

        //

        self::assertEquals([], $url->getAvailableDomains());

        //

        $url = $this->mock(['test.ru']);

        self::assertEquals(['test.ru'], $url->getAvailableDomains());
    }

    protected function mock(array $domains = []): AbstractOriginUrlBuilder
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

            public function toFileFromFetchUrl(string $fetchUrl, string $filePath, string $branch): string
            {
                return '';
            }
        };
    }

    public function providerForTestToGitFolder(): array
    {
        return [
            [
                'http://domain.ru/branch.git',
                'http://domain.ru/branch',
            ],
            [
                Str::make('http://domain.ru/branch.git'),
                'http://domain.ru/branch',
            ],
        ];
    }

    /**
     * @dataProvider providerForTestToGitFolder
     * @covers \ArtARTs36\GitHandler\Origin\Url\AbstractOriginUrlBuilder::toGitFolder
     */
    public function testToGitFolder($fetchUrl, string $expected): void
    {
        $url = $this->mock();

        //

        self::assertEquals($expected, $this->callMethodFromObject($url, 'toGitFolder', $fetchUrl));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Origin\Url\AbstractOriginUrlBuilder::__construct
     */
    public function testConstruct(): void
    {
        $url = $this->mock(['site.ru']);

        self::assertEqualsPropertyValueOfObject($url, 'domains', ['site.ru']);
    }

    /**
     * @covers \ArtARTs36\GitHandler\Origin\Url\AbstractOriginUrlBuilder::__construct
     */
    public function testConstructOnMerge(): void
    {
        $url = $this->mock([]);

        $this->setPropertyValue($url, 'domains', ['site1.ru']);
        $url->__construct(['site2.ru']);

        self::assertEqualsPropertyValueOfObject($url, 'domains', ['site1.ru', 'site2.ru']);
    }

    /**
     * @covers \ArtARTs36\GitHandler\Origin\Url\AbstractOriginUrlBuilder::toRepoFromUrl
     */
    public function testToRepoFromUrlOnGivenInvalidUri(): void
    {
        $url = $this->mock();

        self::expectException(GivenInvalidUri::class);

        $url->toRepoFromUrl('1');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Origin\Url\AbstractOriginUrlBuilder::toRepoFromUrl
     */
    public function testToRepoFromUrlOnTwoPathParts(): void
    {
        $url = $this->mock();

        self::assertEquals('site.ru/site', $url->toRepoFromUrl('site.ru/site')->url);
    }
}
