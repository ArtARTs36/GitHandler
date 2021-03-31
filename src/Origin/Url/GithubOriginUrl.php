<?php

namespace ArtARTs36\GitHandler\Origin\Url;

use ArtARTs36\GitHandler\Contracts\OriginUrl;

class GithubOriginUrl extends AbstractOriginUrl implements OriginUrl
{
    public function toCommitFromFetchUrl(string $fetchUrl, string $hash): string
    {
        return $this->toGitFolder($fetchUrl)->append('/commit/'. $hash);
    }

    public function toArchiveFromFetchUrl(string $fetchUrl, string $branch = 'master'): string
    {
        return $this->toGitFolder($fetchUrl)->append("/archive/refs/heads/$branch.zip");
    }
}
