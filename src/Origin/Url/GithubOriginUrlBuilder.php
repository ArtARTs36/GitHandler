<?php

namespace ArtARTs36\GitHandler\Origin\Url;

use ArtARTs36\GitHandler\Contracts\Origin\OriginUrlBuilder;
use ArtARTs36\GitHandler\Support\Uri;

class GithubOriginUrlBuilder extends AbstractOriginUrlBuilder implements OriginUrlBuilder
{
    protected $archiveSubdomain = 'codeload';

    protected $domains = [
        'github.com',
    ];

    public function toCommitFromFetchUrl(string $fetchUrl, string $hash): string
    {
        return $this->toGitFolder($fetchUrl)->append('/commit/'. $hash);
    }

    public function toArchiveFromFetchUrl(string $fetchUrl, string $branch = 'master'): string
    {
        $host = Uri::host($fetchUrl);

        return $this
            ->toGitFolder($fetchUrl)
            ->replace([
                $host => $this->buildArchiveDomain($host),
            ])
            ->append("/zip/refs/heads/$branch");
    }

    public function toTagFromFetchUrl(string $fetchUrl, string $tag): string
    {
        return $this->toGitFolder($fetchUrl)->append('/releases/tag/')->append($tag);
    }

    protected function buildArchiveDomain(string $host): string
    {
        return $this->archiveSubdomain . '.' . $host;
    }
}
