<?php

namespace ArtARTs36\GitHandler;

use ArtARTs36\GitHandler\Contracts\GitHandler;
use ArtARTs36\GitHandler\Contracts\HasRemotes;
use ArtARTs36\GitHandler\Origin\Url\OriginUrlFactory;

class RepositoryDownloader
{
    protected $url;

    public function __construct(OriginUrlFactory $url)
    {
        $this->url = $url;
    }

    public function download(HasRemotes $git, string $pathToSave)
    {
        $remotes = $git->showRemote()->fetch;
    }
}
