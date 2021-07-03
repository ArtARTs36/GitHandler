<?php

namespace ArtARTs36\GitHandler\Origin\Url;

use ArtARTs36\GitHandler\Contracts\HasRemotes;
use ArtARTs36\GitHandler\Contracts\OriginUrl;
use ArtARTs36\GitHandler\Data\Repo;
use ArtARTs36\GitHandler\Exceptions\GivenInvalidUri;
use ArtARTs36\GitHandler\Support\Uri;
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

    public function toRepoFromUrl(string $url): Repo
    {
        $urlParts = parse_url($url);
        $pathParts = array_filter(explode(DIRECTORY_SEPARATOR, $urlParts['path']));

        if (count($pathParts) < 2) {
            throw new GivenInvalidUri($url);
        }

        [$user, $name] = array_slice($pathParts, 0, 2);

        return new Repo($name, $user, Uri::unParse(array_merge($urlParts, [
            'path' => $user . '/' . $name,
        ])));
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
