<?php

namespace ArtARTs36\GitHandler\Contracts;

use ArtARTs36\GitHandler\Origin\Url\GitUrl;

interface HasUrl
{
    /**
     * Git urls.
     * @param array<string, string> $domainMap
     */
    public function urls(array $domainMap = []): GitUrl;
}
