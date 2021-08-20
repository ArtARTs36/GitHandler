<?php

namespace ArtARTs36\GitHandler\Contracts\Handler;

use ArtARTs36\GitHandler\Contracts\Commands\GitRemoteCommand;

interface HasRemotes
{
    public function remotes(): GitRemoteCommand;
}
