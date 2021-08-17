<?php

namespace ArtARTs36\GitHandler\Tests\Origin;

use ArtARTs36\GitHandler\Exceptions\GivenInvalidUri;
use ArtARTs36\GitHandler\Origin\Url\GitlabOriginUrlBuilder;
use ArtARTs36\GitHandler\Tests\Support\MockHasRemotes;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class GitlabOriginUrlTest extends TestCase
{
    public function toCommitDataProvider(): array
    {
        return [
            [
                'https://gitlab.com/artem_ukrainsky/testing-laravel.git',
                'e62ef13e5676e0ceb4a829679a33f530e2ecc788',
                'https://gitlab.com/artem_ukrainsky/testing-laravel/-/commit/e62ef13e5676e0ceb4a829679a33f530e2ecc788',
            ],
        ];
    }

    public function toArchiveDataProvider(): array
    {
        return [
            [
                'https://gitlab.com/artem_ukrainsky/testing-laravel.git',
                'master',
                'https://gitlab.com/artem_ukrainsky/testing-laravel/-/archive/master/testing-laravel-master.zip',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\GitHandler\Origin\Url\GitlabOriginUrlBuilder::toCommit
     * @covers \ArtARTs36\GitHandler\Origin\Url\GitlabOriginUrlBuilder::toCommitFromFetchUrl
     * @dataProvider toCommitDataProvider
     */
    public function testToCommit(string $fetch, string $commit, string $expected): void
    {
        $git = new MockHasRemotes($fetch);
        $url = new GitlabOriginUrlBuilder();

        //

        self::assertEquals($expected, $url->toCommit($git, $commit));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Origin\Url\GitlabOriginUrlBuilder::toArchive
     * @covers \ArtARTs36\GitHandler\Origin\Url\GitlabOriginUrlBuilder::toArchiveFromFetchUrl
     * @dataProvider toArchiveDataProvider
     */
    public function testToArchive(string $fetch, string $branch, string $expected): void
    {
        $git = new MockHasRemotes($fetch);
        $url = new GitlabOriginUrlBuilder();

        self::assertEquals($expected, $url->toArchive($git, $branch));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Origin\Url\GitlabOriginUrlBuilder::toRepoFromUrl
     */
    public function testToRepoFromUrl(): void
    {
        self::assertEquals([
            'name' => 'testing-laravel',
            'user' => 'artem_ukrainsky',
            'url'  => 'https://gitlab.com/artem_ukrainsky/testing-laravel',
        ], (new GitlabOriginUrlBuilder())
            ->toRepoFromUrl(
                'https://gitlab.com/artem_ukrainsky/testing-laravel/-/commit/e62ef13e5676e0ceb4a829679a33f530e2ecc788'
            )
            ->toArray());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Origin\Url\GitlabOriginUrlBuilder::toRepoFromUrl
     */
    public function testToRepoFromUrlOnIncorrectUri(): void
    {
        self::expectException(GivenInvalidUri::class);

        (new GitlabOriginUrlBuilder())->toRepoFromUrl('h');
    }
}
