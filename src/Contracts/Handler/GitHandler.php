<?php

namespace ArtARTs36\GitHandler\Contracts\Handler;

use ArtARTs36\GitHandler\Command\Groups\Contracts\GitFileCommand;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitIndexCommand;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitInitCommand;

interface GitHandler extends Versionable, HasRemotes
{
    /**
     * Git Init
     */
    public function inits(): GitInitCommand;

    /**
     * Git Files
     */
    public function files(): GitFileCommand;

    /**
     * Git Index
     */
    public function index(): GitIndexCommand;
}
