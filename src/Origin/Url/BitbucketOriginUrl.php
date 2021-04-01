<?php

namespace ArtARTs36\GitHandler\Origin\Url;

class BitbucketOriginUrl extends AbstractOriginUrl
{
    protected $domains = [
        'bitbucket.org',
    ];

    public function toCommitFromFetchUrl(string $fetchUrl, string $hash): string
    {
        return $this->toGitFolder($fetchUrl)->append('/commits/'. $hash);
    }

    public function toArchiveFromFetchUrl(string $fetchUrl, string $branch = 'master'): string
    {
        return $this->toGitFolder($fetchUrl)->append("/get/$branch.zip");
    }
}
