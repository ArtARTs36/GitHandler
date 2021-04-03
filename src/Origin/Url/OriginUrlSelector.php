<?php

namespace ArtARTs36\GitHandler\Origin\Url;

use ArtARTs36\GitHandler\Contracts\HasRemotes;
use ArtARTs36\GitHandler\Contracts\OriginUrl;
use ArtARTs36\GitHandler\Exceptions\OriginUrlNotFound;

class OriginUrlSelector
{
    protected $map = [];

    /**
     * @param array<string, OriginUrl> $map
     * @codeCoverageIgnore
     */
    public function __construct(array $map)
    {
        $this->map = $map;
    }

    /**
     * @param array<string, OriginUrl> $urls
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
    public function select(HasRemotes $git): OriginUrl
    {
        return $this->selectByDomain(parse_url($git->showRemote()->fetch, PHP_URL_HOST));
    }

    /**
     * @throws OriginUrlNotFound
     */
    public function selectByDomain(string $domain): OriginUrl
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
