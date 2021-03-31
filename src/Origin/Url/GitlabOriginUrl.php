<?php

namespace ArtARTs36\GitHandler\Origin\Url;

use ArtARTs36\GitHandler\Contracts\HasRemotes;
use ArtARTs36\GitHandler\Contracts\OriginUrl;

class GitlabOriginUrl extends AbstractOriginUrl implements OriginUrl
{
    public function toCommit(HasRemotes $git, string $hash): string
    {
        return $this->toGitFolder($git)->append('/-/commit/'. $hash);
    }

    public function toArchive(HasRemotes $git, string $branch = 'master'): string
    {
        $folder = $this->toGitFolder($git);
        $repoName = pathinfo($folder, PATHINFO_BASENAME);

        return $folder->append("/-/archive/$branch/$repoName-$branch.zip");
    }
}
