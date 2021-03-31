<?php

namespace ArtARTs36\GitHandler\Origin\Url;

use ArtARTs36\GitHandler\Contracts\HasRemotes;
use ArtARTs36\GitHandler\Contracts\OriginUrl;
use ArtARTs36\Str\Str;

abstract class AbstractOriginUrl implements OriginUrl
{
    public function toCommit(HasRemotes $git, string $hash): string
    {
        return $this->toCommitFromFetchUrl($git->showRemote()->fetch, $hash);
    }

    public function toArchive(HasRemotes $git, string $branch = 'master'): string
    {
        return $this->toArchiveFromFetchUrl($git->showRemote()->fetch, $branch);
    }

    /**
     * @param Str|string $fetchUrl
     */
    protected function toGitFolder($fetchUrl): Str
    {
        if (! $fetchUrl instanceof Str) {
            $fetchUrl = Str::make($fetchUrl);
        }

        return $fetchUrl->delete(['.git']);
    }
}
