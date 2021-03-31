<?php

namespace ArtARTs36\GitHandler;

use ArtARTs36\GitHandler\Contracts\GitHandler;
use ArtARTs36\GitHandler\Contracts\HasRemotes;
use ArtARTs36\GitHandler\Origin\Url\OriginUrlFactory;

class RepositoryDownloader
{
    protected $git;

    protected $url;

    public function __construct(HasRemotes $git, OriginUrlFactory $url)
    {
        $this->git = $git;
        $this->url = $url;
    }

    public function download(string $pathToSave)
    {
        $remotes = $this->git->showRemote()->fetch;
    }
}
