<?php

namespace ArtARTs36\GitHandler\Origin\Url;

use ArtARTs36\GitHandler\Contracts\OriginUrl;

class GitlabOriginUrl extends AbstractOriginUrl implements OriginUrl
{
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
}
