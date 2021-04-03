<?php

namespace ArtARTs36\GitHandler\Origin\Url;

use ArtARTs36\GitHandler\Contracts\OriginUrl;

class GithubOriginUrl extends AbstractOriginUrl implements OriginUrl
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
        $host = parse_url($fetchUrl, PHP_URL_HOST);

        return $this
            ->toGitFolder($fetchUrl)
            ->replace([
                $host => $this->buildArchiveDomain($host),
            ])
            ->append("/zip/refs/heads/$branch");
    }

    protected function buildArchiveDomain(string $host): string
    {
        return $this->archiveSubdomain . '.' . $host;
    }
}
