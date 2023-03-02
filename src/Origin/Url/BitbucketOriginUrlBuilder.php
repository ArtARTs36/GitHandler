<?php

namespace ArtARTs36\GitHandler\Origin\Url;

class BitbucketOriginUrlBuilder extends AbstractOriginUrlBuilder
{
    public const NAME = 'bitbucket';

    /** @var list<string> */
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

    public function toTagFromFetchUrl(string $fetchUrl, string $tag): string
    {
        return $this->toGitFolder($fetchUrl)->append('/src/')->append($tag);
    }

    public function toTagsCompareFromFetchUrl(string $fetchUrl, string $oneTag, string $twoTag): string
    {
        return $this->toGitFolder($fetchUrl)->append("/branches/compare/$oneTag%0D$twoTag");
    }

    public function toFileFromFetchUrl(string $fetchUrl, string $filePath, string $branch): string
    {
        return $this->toGitFolder($fetchUrl)->append("/src/$branch/$filePath");
    }
}
