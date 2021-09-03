<?php

namespace ArtARTs36\GitHandler\Contracts\Commands;

interface HasSubmodules
{
    /**
     * Git submodules
     */
    public function submodules(): GitSubmoduleCommand;
}
