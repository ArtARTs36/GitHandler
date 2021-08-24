<?php

namespace ArtARTs36\GitHandler\Exceptions;

class BranchNotFound extends GitHandlerException
{
    public $errorBranch;

    public function __construct(string $branch)
    {
        $this->errorBranch = $branch;

        $message = "Git Branch '{$branch}' Not Found";

        parent::__construct($message);
    }
}
