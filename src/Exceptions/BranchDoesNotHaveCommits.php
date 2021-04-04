<?php

namespace ArtARTs36\GitHandler\Exceptions;

use Throwable;

class BranchDoesNotHaveCommits extends GitHandlerException
{
    public $errorBranch;

    public function __construct(string $errorBranch, $code = 0, Throwable $previous = null)
    {
        $this->errorBranch = $errorBranch;

        $message = "branch '$errorBranch' does not have any commits yet";

        parent::__construct($message, $code, $previous);
    }
}
