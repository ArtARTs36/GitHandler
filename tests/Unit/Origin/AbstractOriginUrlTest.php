<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Origin;

use ArtARTs36\GitHandler\Origin\Url\AbstractOriginUrlBuilder;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class AbstractOriginUrlTest extends TestCase
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
                //
            }

            public function toCommitFromFetchUrl(string $fetchUrl, string $hash): string
            {
                //
            }

            public function toTagFromFetchUrl(string $fetchUrl, string $tag): string
            {
                // TODO: Implement toTagFromFetchUrl() method.
            }
        };
    }

    /**
     * @covers \ArtARTs36\GitHandler\Origin\Url\AbstractOriginUrlBuilder::toGitFolder
     */
    public function testToGitFolder(): void
    {
        $url = $this->mock();

        //

        self::assertEquals(
            'http://domain.ru/branch',
            $this->callMethodFromObject($url, 'toGitFolder', 'http://domain.ru/branch.git')
        );
    }
}
