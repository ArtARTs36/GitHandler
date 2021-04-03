<?php

namespace ArtARTs36\GitHandler\Exceptions;

use Throwable;

class BranchNotFound extends FileNotFound
{
    public function __construct(string $branch, int $code = 0, Throwable $previous = null)
    {
        $message = "Git Branch '{$branch}' Not Found";

        parent::__construct($message, $code, $previous);
    }
}
