<?php

namespace ArtARTs36\GitHandler\Origin\Url;

use ArtARTs36\GitHandler\Contracts\Handler\HasRemotes;
use ArtARTs36\GitHandler\Contracts\Origin\OriginUrlBuilder;
use ArtARTs36\GitHandler\Data\Repo;
use ArtARTs36\GitHandler\Exceptions\GivenInvalidUri;
use ArtARTs36\GitHandler\Support\Uri;
use ArtARTs36\Str\Str;

abstract class AbstractOriginUrlBuilder implements OriginUrlBuilder
{
    /** @var list<string> */
    protected $domains = [];

    private const URL_REGEX = '/((git@|http(s)?:\/\/)(?<host>[\w\.@]+)(\/|:))(?<owner>([\w,\-,\_]+))\/' .
    '(?<repo>([\w,\-,\_]+))(.git){0,1}((\/){0,1})/m';

    /**
     * @param array<string> $domains
     */
    public function __construct(array $domains = [])
    {
        $this->domains = array_merge($this->domains, $domains);
    }

    public function toCommit(HasRemotes $git, string $hash): string
    {
        return $this->toCommitFromFetchUrl($git->remotes()->show()->fetch, $hash);
    }

    public function toArchive(HasRemotes $git, string $branch = 'master'): string
    {
        return $this->toArchiveFromFetchUrl($git->remotes()->show()->fetch, $branch);
    }

    public function getAvailableDomains(): array
    {
        return $this->domains;
    }

    public function toRepoFromUrl(string $url): Repo
    {
        $parsed = [];

        preg_match(self::URL_REGEX, $url, $parsed);

        if (! isset($parsed['repo']) || ! isset($parsed['owner']) || ! isset($parsed['host'])) {
            throw new GivenInvalidUri($url);
        }

        $newUrl = Uri::unParse([
            'scheme' => 'https',
            'host' => $parsed['host'],
            'path' => $parsed['owner'] . '/' . $parsed['repo'],
        ]);

        return new Repo($parsed['repo'], $parsed['owner'], $newUrl);
    }

    /**
     * @param Str|string $fetchUrl
     */
    protected function toGitFolder($fetchUrl): Str
    {
        if (is_string($fetchUrl)) {
            $fetchUrl = Str::make($fetchUrl);
        }

        return $fetchUrl->delete(['.git']);
    }
}
