<?php

namespace ArtARTs36\GitHandler\Exceptions;

class BranchDoesNotHaveCommits extends GitHandlerException
{
    public $errorBranch;

    public function __construct(string $errorBranch)
    {
        $this->errorBranch = $errorBranch;

        $message = "branch '$errorBranch' does not have any commits yet";

        parent::__construct($message);
    }
}
