<?php

namespace ArtARTs36\GitHandler\Tests\Origin;

use ArtARTs36\GitHandler\Contracts\HasRemotes;
use ArtARTs36\GitHandler\Data\Remotes;
use ArtARTs36\GitHandler\Origin\Url\GithubOriginUrl;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;
use ArtARTs36\Str\Str;

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

    /**
     * @covers \ArtARTs36\GitHandler\Origin\Url\GithubOriginUrl::toCommit
     * @dataProvider toCommitDataProvider
     */
    public function testToCommit(string $fetch, string $commit, string $expected): void
    {
        $git = new class($fetch) implements HasRemotes {
            private $fetch;

            public function __construct(string $fetch)
            {
                $this->fetch = $fetch;
            }

            public function showRemote(): Remotes
            {
                return new Remotes(new Str($this->fetch), new Str(''));
            }

            public function addRemote(string $shortName, string $url): bool
            {
                //
            }
        };

        //

        $url = new GithubOriginUrl();

        //

        self::assertEquals($expected, $url->toCommit($git, $commit));
    }
}
