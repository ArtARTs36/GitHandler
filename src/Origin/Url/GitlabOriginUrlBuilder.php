<?php

namespace ArtARTs36\GitHandler\Origin\Url;

use ArtARTs36\GitHandler\Contracts\Origin\OriginUrlBuilder;

class GitlabOriginUrlBuilder extends AbstractOriginUrlBuilder implements OriginUrlBuilder
{
    public const NAME = 'gitlab';

    /** @var list<string> */
    protected $domains = [
        'gitlab.com',
    ];

    public function toCommitFromFetchUrl(string $fetchUrl, string $hash): string
    {
        return $this->toGitFolder($fetchUrl)->append('/-/commit/'. $hash);
    }

    public function toArchiveFromFetchUrl(string $fetchUrl, string $branch = 'master'): string
    {
        $folder = $this->toGitFolder($fetchUrl);
        $repoName = pathinfo($folder, PATHINFO_BASENAME);

        return $folder->append("/-/archive/$branch/$repoName-$branch.zip");
    }

    public function toTagFromFetchUrl(string $fetchUrl, string $tag): string
    {
        return $this->toGitFolder($fetchUrl)->append('/-/tags/'. $tag);
    }

    public function toTagsCompareFromFetchUrl(string $fetchUrl, string $oneTag, string $twoTag): string
    {
        return $this->toGitFolder($fetchUrl)->append("-/compare/$oneTag...$twoTag");
    }

    public function toFileFromFetchUrl(string $fetchUrl, string $filePath, string $branch): string
    {
        return $this->toGitFolder($fetchUrl)->append("/-/blob/$branch/$filePath");
    }
}
