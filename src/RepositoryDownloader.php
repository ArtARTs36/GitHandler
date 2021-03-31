<?php

namespace ArtARTs36\GitHandler;

use ArtARTs36\GitHandler\Contracts\HasRemotes;
use ArtARTs36\GitHandler\Origin\Url\OriginUrlFactory;

class RepositoryDownloader
{
    protected $url;

    public function __construct(OriginUrlFactory $url)
    {
        $this->url = $url;
    }

    public function origin(HasRemotes $git, string $pathToSave): bool
    {
        return file_put_contents($pathToSave, $this->download($git)) !== false;
    }

    protected function download(HasRemotes $git): string
    {
        return file_get_contents($this->url->factory($git)->toArchive($git));
    }
}
