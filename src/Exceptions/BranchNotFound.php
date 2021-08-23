<?php

namespace ArtARTs36\GitHandler\Exceptions;

use ArtARTs36\Str\Str;

class BranchNotFound extends GitHandlerException
{
    public $errorBranch;

    public function __construct(string $branch)
    {
        $this->errorBranch = $branch;

        $message = "Git Branch '{$branch}' Not Found";

        parent::__construct($message);
    }

    public static function handleIfSo(Str $err): void
    {
        if (($path = $err->match("/pathspec '(.*)' did not match any/i")) &&
            $path->isNotEmpty()) {
            throw new self($path);
        }
    }
}
