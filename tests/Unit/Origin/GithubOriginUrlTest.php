<?php

namespace ArtARTs36\GitHandler\Tests\Origin;

use ArtARTs36\GitHandler\Origin\Url\GithubOriginUrl;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

class GithubOriginUrlTest extends TestCase
{
    public function toCommitDataProvider(): array
    {
        return [
            [
                'https://github.com/ArtARTs36/GitHandler.git',
                'a35d40a7226e8bc941fbabaf7534c33ca88380a7',
                'https://github.com/ArtARTs36/GitHandler/commit/a35d40a7226e8bc941fbabaf7534c33ca88380a7',
            ],
        ];
    }

    public function toArchiveDataProvider(): array
    {
        return [
            [
                'https://github.com/ArtARTs36/GitHandler.git',
                'master',
                'https://codeload.github.com/ArtARTs36/GitHandler/zip/refs/heads/master',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\GitHandler\Origin\Url\GithubOriginUrl::toCommit
     * @covers \ArtARTs36\GitHandler\Origin\Url\GithubOriginUrl::toCommitFromFetchUrl
     * @dataProvider toCommitDataProvider
     */
    public function testToCommit(string $fetch, string $commit, string $expected): void
    {
        $git = $this->mockHasRemotes($fetch);
        $url = new GithubOriginUrl();

        //

        self::assertEquals($expected, $url->toCommit($git, $commit));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Origin\Url\GithubOriginUrl::toArchive
     * @covers \ArtARTs36\GitHandler\Origin\Url\GithubOriginUrl::toArchiveFromFetchUrl
     * @dataProvider toArchiveDataProvider
     */
    public function testToArchive(string $fetch, string $branch, string $expected): void
    {
        $git = $this->mockHasRemotes($fetch);
        $url = new GithubOriginUrl();

        self::assertEquals($expected, $url->toArchive($git, $branch));
    }
}
