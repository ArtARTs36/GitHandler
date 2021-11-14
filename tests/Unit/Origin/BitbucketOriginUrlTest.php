<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Origin;

use ArtARTs36\GitHandler\Exceptions\GivenInvalidUri;
use ArtARTs36\GitHandler\Origin\Url\BitbucketOriginUrlBuilder;
use ArtARTs36\GitHandler\Tests\Support\MockHasRemotes;
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
     * @covers \ArtARTs36\GitHandler\Origin\Url\BitbucketOriginUrlBuilder::toCommitFromFetchUrl
     * @dataProvider toCommitDataProvider
     */
    public function testToCommit(string $fetch, string $commit, string $expected): void
    {
        $git = new MockHasRemotes($fetch);
        $url = new BitbucketOriginUrlBuilder();

        //

        self::assertEquals($expected, $url->toCommit($git, $commit));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Origin\Url\BitbucketOriginUrlBuilder::toArchiveFromFetchUrl
     * @dataProvider toArchiveDataProvider
     */
    public function testToArchive(string $fetch, string $branch, string $expected): void
    {
        $git = new MockHasRemotes($fetch);
        $url = new BitbucketOriginUrlBuilder();

        self::assertEquals($expected, $url->toArchive($git, $branch));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Origin\Url\BitbucketOriginUrlBuilder::toRepoFromUrl
     */
    public function testToRepoFromUrl(): void
    {
        $repo = (new BitbucketOriginUrlBuilder())
            ->toRepoFromUrl('https://bitbucket.org/aukrainsky/test-repo/src/master/');

        self::assertEquals([
            'user' => 'aukrainsky',
            'name' => 'test-repo',
            'url' => 'https://bitbucket.org/aukrainsky/test-repo',
        ], $repo->toArray());
    }

    public function providerForTestToRepoFromUrlOnIncorrectUri(): array
    {
        return [
            ['h'],
            ['https://bitbucket.org/aukrainsky/'],
        ];
    }

    /**
     * @dataProvider providerForTestToRepoFromUrlOnIncorrectUri
     * @covers \ArtARTs36\GitHandler\Origin\Url\BitbucketOriginUrlBuilder::toRepoFromUrl
     */
    public function testToRepoFromUrlOnIncorrectUri(string $url): void
    {
        self::expectException(GivenInvalidUri::class);

        (new BitbucketOriginUrlBuilder())->toRepoFromUrl($url);
    }

    /**
     * @covers \ArtARTs36\GitHandler\Origin\Url\BitbucketOriginUrlBuilder::toTagFromFetchUrl
     */
    public function testToTagFromFetchUrl(): void
    {
        self::assertEquals(
            'https://bitbucket.org/aukrainsky/a1/src/1.0.0',
            (new BitbucketOriginUrlBuilder())->toTagFromFetchUrl('https://bitbucket.org/aukrainsky/a1', '1.0.0')
        );
    }

    /**
     * @covers \ArtARTs36\GitHandler\Origin\Url\BitbucketOriginUrlBuilder::toTagsCompareFromFetchUrl
     */
    public function testToTagsCompareFromFetchUrl(): void
    {
        self::assertEquals(
            'https://bitbucket.org/aukrainsky/a1/branches/compare/1.0.0%0D0.1.1',
            (new BitbucketOriginUrlBuilder())
                ->toTagsCompareFromFetchUrl(
                    'https://bitbucket.org/aukrainsky/a1',
                    '1.0.0',
                    '0.1.1'
                )
        );
    }

    /**
     * @covers \ArtARTs36\GitHandler\Origin\Url\GitlabOriginUrlBuilder::toFileFromFetchUrl
     */
    public function testToFileFromFetchUrl(): void
    {
        $builder = new BitbucketOriginUrlBuilder();

        self::assertEquals(
            'https://bitbucket.org/aukrainsky/a1/src/master/.gitignore',
            $builder
                ->toFileFromFetchUrl(
                    'https://bitbucket.org/aukrainsky/a1',
                    '.gitignore',
                    'master'
                )
        );
    }
}
