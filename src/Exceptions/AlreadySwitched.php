<?php

namespace ArtARTs36\GitHandler\Exceptions;

use JetBrains\PhpStorm\Immutable;
use Throwable;

class AlreadySwitched extends GitHandlerException
{
    #[Immutable]
    public $errorBranch;

    public function __construct(string $branch)
    {
        $this->errorBranch = $branch;

        parent::__construct('Already on '. $branch);
    }
}
