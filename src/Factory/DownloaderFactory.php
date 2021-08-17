<?php

namespace ArtARTs36\GitHandler\Factory;

use ArtARTs36\GitHandler\Contracts\FileSystem;
use ArtARTs36\GitHandler\Contracts\Origin\OriginDownloader;
use ArtARTs36\GitHandler\Origin\Downloader;
use ArtARTs36\GitHandler\Origin\Url\BitbucketOriginUrl;
use ArtARTs36\GitHandler\Origin\Url\GithubOriginUrlBuilder;
use ArtARTs36\GitHandler\Origin\Url\GitlabOriginUrlBuilder;
use ArtARTs36\GitHandler\Origin\Url\OriginUrlSelector;
use Psr\Http\Client\ClientInterface;

class DownloaderFactory
{
    public function factory(ClientInterface $client, FileSystem $files): OriginDownloader
    {
        return new Downloader(
            OriginUrlSelector::make([
                    new GithubOriginUrlBuilder(),
                    new GitlabOriginUrlBuilder(),
                    new BitbucketOriginUrl(),
            ]),
            $client,
            $files
        );
    }
}
