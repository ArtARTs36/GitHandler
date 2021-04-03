<?php

namespace ArtARTs36\GitHandler\Exceptions;

use Throwable;

class BranchAlreadyExists extends GitHandlerException
{
    public $errorBranch;

    public function __construct(string $branch, $code = 0, Throwable $previous = null)
    {
        $this->errorBranch = $branch;

        $message = "Branch {$branch} already exists";

        parent::__construct($message, $code, $previous);
    }
}
