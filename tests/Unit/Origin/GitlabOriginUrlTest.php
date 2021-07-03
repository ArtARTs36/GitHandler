<?php

namespace ArtARTs36\GitHandler\Tests\Origin;

use ArtARTs36\GitHandler\Exceptions\GivenInvalidUri;
use ArtARTs36\GitHandler\Origin\Url\GitlabOriginUrl;
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
     * @covers \ArtARTs36\GitHandler\Origin\Url\GitlabOriginUrl::toCommit
     * @covers \ArtARTs36\GitHandler\Origin\Url\GitlabOriginUrl::toCommitFromFetchUrl
     * @dataProvider toCommitDataProvider
     */
    public function testToCommit(string $fetch, string $commit, string $expected): void
    {
        $git = $this->mockHasRemotes($fetch);
        $url = new GitlabOriginUrl();

        //

        self::assertEquals($expected, $url->toCommit($git, $commit));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Origin\Url\GitlabOriginUrl::toArchive
     * @covers \ArtARTs36\GitHandler\Origin\Url\GitlabOriginUrl::toArchiveFromFetchUrl
     * @dataProvider toArchiveDataProvider
     */
    public function testToArchive(string $fetch, string $branch, string $expected): void
    {
        $git = $this->mockHasRemotes($fetch);
        $url = new GitlabOriginUrl();

        self::assertEquals($expected, $url->toArchive($git, $branch));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Origin\Url\GitlabOriginUrl::toRepoFromUrl
     */
    public function testToRepoFromUrl(): void
    {
        self::assertEquals([
            'name' => 'testing-laravel',
            'user' => 'artem_ukrainsky',
            'url'  => 'https://gitlab.com/artem_ukrainsky/testing-laravel',
        ], (new GitlabOriginUrl())
            ->toRepoFromUrl(
                'https://gitlab.com/artem_ukrainsky/testing-laravel/-/commit/e62ef13e5676e0ceb4a829679a33f530e2ecc788'
            )
            ->toArray());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Origin\Url\GitlabOriginUrl::toRepoFromUrl
     */
    public function testToRepoFromUrlOnIncorrectUri(): void
    {
        self::expectException(GivenInvalidUri::class);

        (new GitlabOriginUrl())->toRepoFromUrl('h');
    }
}
