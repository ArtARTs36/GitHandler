<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Origin;

use ArtARTs36\GitHandler\Exceptions\GivenInvalidUri;
use ArtARTs36\GitHandler\Origin\Url\GithubOriginUrlBuilder;
use ArtARTs36\GitHandler\Tests\Support\MockHasRemotes;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class GithubOriginUrlTest extends TestCase
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
     * @covers \ArtARTs36\GitHandler\Origin\Url\GithubOriginUrlBuilder::toCommit
     * @covers \ArtARTs36\GitHandler\Origin\Url\GithubOriginUrlBuilder::toCommitFromFetchUrl
     * @dataProvider toCommitDataProvider
     */
    public function testToCommit(string $fetch, string $commit, string $expected): void
    {
        $git = new MockHasRemotes($fetch);
        $url = new GithubOriginUrlBuilder();

        //

        self::assertEquals($expected, $url->toCommit($git, $commit));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Origin\Url\GithubOriginUrlBuilder::toArchive
     * @covers \ArtARTs36\GitHandler\Origin\Url\GithubOriginUrlBuilder::toArchiveFromFetchUrl
     * @dataProvider toArchiveDataProvider
     */
    public function testToArchive(string $fetch, string $branch, string $expected): void
    {
        $git = new MockHasRemotes($fetch);
        $url = new GithubOriginUrlBuilder();

        self::assertEquals($expected, $url->toArchive($git, $branch));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Origin\Url\GithubOriginUrlBuilder::buildArchiveDomain
     */
    public function testBuildArchiveDomain(): void
    {
        $url = new GithubOriginUrlBuilder();

        self::assertEquals(
            'codeload.github.com',
            $this->callMethodFromObject($url, 'buildArchiveDomain', 'github.com')
        );
    }

    /**
     * @covers \ArtARTs36\GitHandler\Origin\Url\GithubOriginUrlBuilder::toRepoFromUrl
     */
    public function testToRepoFromUrl(): void
    {
        self::assertEquals([
            'name' => 'GitHandler',
            'user' => 'ArtARTs36',
            'url'  => 'https://github.com/ArtARTs36/GitHandler',
        ], (new GithubOriginUrlBuilder())
            ->toRepoFromUrl('https://github.com/ArtARTs36/GitHandler/tree/master/src')
            ->toArray());
    }

    /**
     * @covers \ArtARTs36\GitHandler\Origin\Url\GithubOriginUrlBuilder::toRepoFromUrl
     */
    public function testToRepoFromUrlOnIncorrectUri(): void
    {
        self::expectException(GivenInvalidUri::class);

        (new GithubOriginUrlBuilder())->toRepoFromUrl('h');
    }

    /**
     * @covers \ArtARTs36\GitHandler\Origin\Url\GithubOriginUrlBuilder::toTagFromFetchUrl
     */
    public function testToTagFromFetchUrl(): void
    {
        self::assertEquals(
            'https://github.com/ArtARTs36/GitHandler/releases/tag/1.0.0',
            $this->makeGithubOriginUrl()->toTagFromFetchUrl('https://github.com/ArtARTs36/GitHandler', '1.0.0')
        );
    }


    /**
     * @covers \ArtARTs36\GitHandler\Origin\Url\GithubOriginUrlBuilder::toTagsCompareFromFetchUrl
     */
    public function testToTagsCompareFromFetchUrl(): void
    {
        self::assertEquals(
            'https://github.com/ArtARTs36/GitHandler/compare/0.13.0...1.0.0',
            $this
                ->makeGithubOriginUrl()
                ->toTagsCompareFromFetchUrl('https://github.com/ArtARTs36/GitHandler', '0.13.0', '1.0.0')
        );
    }

    /**
     * @covers \ArtARTs36\GitHandler\Origin\Url\GithubOriginUrlBuilder::toFileFromFetchUrl
     */
    public function testToFileFromFetchUrl(): void
    {
        $builder = $this->makeGithubOriginUrl();

        self::assertEquals(
            'https://github.com/ArtARTs36/GitHandler/blob/0.8.0/src/Support/LocalFileSystem.php',
            $builder
                ->toFileFromFetchUrl(
                    'https://github.com/ArtARTs36/GitHandler',
                    'src/Support/LocalFileSystem.php',
                    '0.8.0'
                )
        );
    }

    private function makeGithubOriginUrl(): GithubOriginUrlBuilder
    {
        return new GithubOriginUrlBuilder();
    }
}
