<?php

namespace ArtARTs36\GitHandler\Tests\Origin;

use ArtARTs36\GitHandler\Origin\Url\AbstractOriginUrl;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class AbstractOriginUrlTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Origin\Url\AbstractOriginUrl::getAvailableDomains
     * @covers \ArtARTs36\GitHandler\Origin\Url\AbstractOriginUrl::__construct
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

    protected function mock(array $domains = []): AbstractOriginUrl
    {
        return new class($domains) extends AbstractOriginUrl {
            public function toArchiveFromFetchUrl(string $fetchUrl, string $branch = 'master'): string
            {
                //
            }

            public function toCommitFromFetchUrl(string $fetchUrl, string $hash): string
            {
                //
            }
        };
    }

    /**
     * @covers \ArtARTs36\GitHandler\Origin\Url\AbstractOriginUrl::toGitFolder
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
