<?php

namespace ArtARTs36\GitHandler\Contracts\Origin;

use ArtARTs36\GitHandler\Contracts\Handler\HasRemotes;

interface OriginDownloader
{
    /**
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function download(HasRemotes $git, string $pathToSave): bool;
}
