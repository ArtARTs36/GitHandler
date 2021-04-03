<?php

namespace ArtARTs36\GitHandler\Tests\Origin;

use ArtARTs36\GitHandler\Origin\Url\BitbucketOriginUrl;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class BitbucketOriginUrlTest extends TestCase
{
    public function toCommitDataProvider(): array
    {
        return [
            [
                'https://bitbucket.org/atlassianlabs/maven-project-example.git',
                '128e61b9396814fcf42e431130dafcb92ccbb75d',

                'https://bitbucket.org/atlassianlabs/maven-project-example/commits/'.
                '128e61b9396814fcf42e431130dafcb92ccbb75d',
            ],
        ];
    }

    public function toArchiveDataProvider(): array
    {
        return [
            [
                'https://bitbucket.org/atlassianlabs/maven-project-example.git',
                'master',
                'https://bitbucket.org/atlassianlabs/maven-project-example/get/master.zip',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\GitHandler\Origin\Url\BitbucketOriginUrl::toCommitFromFetchUrl
     * @dataProvider toCommitDataProvider
     */
    public function testToCommit(string $fetch, string $commit, string $expected): void
    {
        $git = $this->mockHasRemotes($fetch);
        $url = new BitbucketOriginUrl();

        //

        self::assertEquals($expected, $url->toCommit($git, $commit));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Origin\Url\BitbucketOriginUrl::toArchiveFromFetchUrl
     * @dataProvider toArchiveDataProvider
     */
    public function testToArchive(string $fetch, string $branch, string $expected): void
    {
        $git = $this->mockHasRemotes($fetch);
        $url = new BitbucketOriginUrl();

        self::assertEquals($expected, $url->toArchive($git, $branch));
    }
}
