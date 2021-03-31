<?php

namespace ArtARTs36\GitHandler\Origin\Url;

use ArtARTs36\GitHandler\Contracts\HasRemotes;
use ArtARTs36\GitHandler\Contracts\OriginUrl;

class GithubOriginUrl extends AbstractOriginUrl implements OriginUrl
{
    public function toCommit(HasRemotes $git, string $hash): string
    {
        return $this->toGitFolder($git)->append('/commit/'. $hash);
    }

    public function toArchive(HasRemotes $git, string $branch = 'master'): string
    {
        return $this->toGitFolder($git)->append("/archive/refs/heads/$branch.zip");
    }
}
