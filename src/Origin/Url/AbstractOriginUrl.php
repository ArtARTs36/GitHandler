<?php

namespace ArtARTs36\GitHandler\Origin\Url;

use ArtARTs36\GitHandler\Contracts\HasRemotes;
use ArtARTs36\GitHandler\Contracts\OriginUrl;
use ArtARTs36\Str\Str;

abstract class AbstractOriginUrl implements OriginUrl
{
    protected $domains = [];

    public function __construct(array $domains = [])
    {
        $this->domains = array_merge($this->domains, $domains);
    }

    public function toCommit(HasRemotes $git, string $hash): string
    {
        return $this->toCommitFromFetchUrl($git->showRemote()->fetch, $hash);
    }

    public function toArchive(HasRemotes $git, string $branch = 'master'): string
    {
        return $this->toArchiveFromFetchUrl($git->showRemote()->fetch, $branch);
    }

    public function getAvailableDomains(): array
    {
        return $this->domains;
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
