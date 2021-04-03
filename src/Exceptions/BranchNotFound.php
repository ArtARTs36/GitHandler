<?php

namespace ArtARTs36\GitHandler\Exceptions;

use Throwable;

class BranchNotFound extends FileNotFound
{
    public $errorBranch;

    public function __construct(string $branch, int $code = 0, Throwable $previous = null)
    {
        $this->errorBranch = $branch;

        $message = "Git Branch '{$branch}' Not Found";

        parent::__construct($message, $code, $previous);
    }
}
