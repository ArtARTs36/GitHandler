<?php

namespace ArtARTs36\GitHandler\Factory;

use ArtARTs36\FileSystem\Contracts\FileSystem;
use ArtARTs36\GitHandler\Contracts\Origin\OriginDownloader;
use ArtARTs36\GitHandler\Origin\Downloader;
use ArtARTs36\GitHandler\Origin\Url\BitbucketOriginUrlBuilder;
use ArtARTs36\GitHandler\Origin\Url\GithubOriginUrlBuilder;
use ArtARTs36\GitHandler\Origin\Url\GitlabOriginUrlBuilder;
use ArtARTs36\GitHandler\Origin\Url\OriginUrlSelector;
use ArtARTs36\GitHandler\Support\LocalFileSystem;
use ArtARTs36\GitHandler\Support\SimpleHttpClient;
use Psr\Http\Client\ClientInterface;

class DownloaderFactory
{
    public function factory(?FileSystem $files = null, ?ClientInterface $client = null): OriginDownloader
    {
        return new Downloader(
            OriginUrlSelector::make([
                new GithubOriginUrlBuilder(),
                new GitlabOriginUrlBuilder(),
                new BitbucketOriginUrlBuilder(),
            ]),
            $client ?? new SimpleHttpClient(),
            $files ?? new LocalFileSystem()
        );
    }
}
