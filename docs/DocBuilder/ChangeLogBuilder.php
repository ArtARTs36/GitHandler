<?php

namespace ArtARTs36\GitHandler\DocBuilder;

use ArtARTs36\FileSystem\Contracts\FileSystem;
use ArtARTs36\GitHandler\Origin\Url\GithubOriginUrlBuilder;
use ArtARTs36\Str\Str;

class ChangeLogBuilder
{
    private $remote;

    private $stubs;

    private $files;

    public function __construct(GithubRepo $remote, StubLoader $stubs, FileSystem $files)
    {
        $this->remote = $remote;
        $this->stubs = $stubs;
        $this->files = $files;
    }

    public function build(string $path): void
    {
        $tags = $this->remote->getTags();

        $content = '';

        $urlBuilder = new GithubOriginUrlBuilder();

        /** @var RemoteTag|null $prev */
        $prev = null;

        foreach ($tags as $tag) {
            $compareLink = $prev === null ?
                $urlBuilder->toTagFromFetchUrl('https://github.com/ArtARTs36/GitHandler', $tag->tag)
                : $urlBuilder->toTagsCompareFromFetchUrl(
                    'https://github.com/ArtARTs36/GitHandler',
                    $prev->tag,
                    $tag->tag
                );

            $content .= $this->stubs->load('changelog_release.md')->render([
                'releaseTitle' => $tag->title,
                'releaseVersion' => $tag->tag,
                'releaseCompareLink' => $compareLink,
                'releaseDescription' => $tag->markdown->lines()->map(function (Str $str) {
                    if ($str->isNotEmpty() && $str->firstSymbol() === '#') {
                        $str = $str->prepend('#');
                    }

                    return $str;
                })->implodeAsLines(),
                'releaseRemoteUrl' => $urlBuilder->toTagFromFetchUrl(
                    'https://github.com/ArtARTs36/GitHandler',
                    $tag->tag
                ),
            ]);

            $prev = $tag;
        }

        $content = $this->stubs->load('changelog.md')->render([
            'releases' => $content,
        ]);

        $this->files->createFile($path, $content);
    }
}
