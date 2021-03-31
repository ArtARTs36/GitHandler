<?php

namespace ArtARTs36\GitHandler;

use ArtARTs36\GitHandler\Contracts\GitHandler;
use ArtARTs36\GitHandler\Contracts\HasRemotes;

class RepositoryDownloader
{
    protected $git;

    public function __construct(HasRemotes $git)
    {
        $this->git = $git;
    }

    public function download(string $pathToSave)
    {
        $remotes = $this->git->showRemote()->fetch;
    }
}
