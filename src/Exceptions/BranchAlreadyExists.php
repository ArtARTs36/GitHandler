<?php

namespace ArtARTs36\GitHandler\Exceptions;

class BranchAlreadyExists extends GitHandlerException
{
    public $errorBranch;

    public function __construct(string $branch)
    {
        $this->errorBranch = $branch;

        $message = "Branch {$branch} already exists";

        parent::__construct($message);
    }
}
