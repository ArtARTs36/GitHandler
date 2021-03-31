<?php

namespace ArtARTs36\GitHandler\Origin\Url;

use ArtARTs36\GitHandler\Contracts\HasRemotes;
use ArtARTs36\GitHandler\Contracts\OriginUrl;
use ArtARTs36\GitHandler\Exceptions\OriginUrlNotFound;

class OriginUrlFactory
{
    protected $map = [
        'gitlab.com' => GitlabOriginUrl::class,
        'github.com' => GithubOriginUrl::class,
    ];

    public function factory(HasRemotes $git): OriginUrl
    {
        return $this->factoryByDomain(parse_url($git->showRemote()->fetch, PHP_URL_HOST));
    }

    public function factoryByDomain(string $domain): OriginUrl
    {
        if (! $this->has($domain)) {
            throw new OriginUrlNotFound();
        }

        $class = $this->map[$domain];

        return new $class;
    }

    public function has(string $domain): bool
    {
        return array_key_exists($domain, $this->map);
    }
}
