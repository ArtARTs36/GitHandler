<?php

namespace ArtARTs36\GitHandler\Contracts\Handler;

use ArtARTs36\GitHandler\Command\Groups\Contracts\GitRemoteCommand;

interface HasRemotes
{
    public function remotes(): GitRemoteCommand;
}
