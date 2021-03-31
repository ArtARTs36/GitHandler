<?php

namespace ArtARTs36\GitHandler\Tests\Origin;

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
     * @covers \ArtARTs36\GitHandler\Origin\Url\GithubOriginUrl::toArchive
     * @dataProvider toArchiveDataProvider
     */
    public function testToArchive(string $fetch, string $branch, string $expected): void
    {
        $git = $this->mockHasRemotes($fetch);
        $url = new GitlabOriginUrl();

        self::assertEquals($expected, $url->toArchive($git, $branch));
    }
}