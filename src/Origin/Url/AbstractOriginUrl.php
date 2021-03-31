<?php

namespace ArtARTs36\GitHandler\Origin\Url;

use ArtARTs36\GitHandler\Contracts\HasRemotes;
use ArtARTs36\Str\Str;

abstract class AbstractOriginUrl
{
    protected function toGitFolder(HasRemotes $git): Str
    {
        return $git->showRemote()->fetch->delete(['.git']);
    }
}
