<?php

namespace ArtARTs36\GitHandler\Origin\Url;

use ArtARTs36\GitHandler\Contracts\Handler\HasRemotes;
use ArtARTs36\GitHandler\Contracts\Origin\OriginUrlBuilder;
use ArtARTs36\GitHandler\Exceptions\OriginUrlNotFound;
use ArtARTs36\GitHandler\Support\Uri;

class OriginUrlSelector
{
    protected $map = [];

    /**
     * @param array<string, OriginUrlBuilder> $map
     * @codeCoverageIgnore
     */
    public function __construct(array $map)
    {
        $this->map = $map;
    }

    /**
     * @param array<OriginUrlBuilder> $urls
     */
    public static function make(array $urls): self
    {
        $map = [];

        foreach ($urls as $url) {
            foreach ($url->getAvailableDomains() as $domain) {
                $map[$domain] = $url;
            }
        }

        return new static($map);
    }

    /**
     * @throws OriginUrlNotFound
     */
    public function select(HasRemotes $git): OriginUrlBuilder
    {
        return $this->selectByUrl($git->remotes()->show()->fetch);
    }

    public function selectByUrl(string $url): OriginUrlBuilder
    {
        return $this->selectByDomain(Uri::host($url));
    }

    /**
     * @throws OriginUrlNotFound
     */
    public function selectByDomain(string $domain): OriginUrlBuilder
    {
        if (! $this->has($domain)) {
            throw new OriginUrlNotFound();
        }

        return $this->map[$domain];
    }

    public function has(string $domain): bool
    {
        return array_key_exists($domain, $this->map);
    }
}
