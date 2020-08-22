<?php

namespace ArtARTs36\GitHandler\Exceptions;

use Throwable;

/**
 * Class BranchNotFound
 * @package ArtARTs36\HostReviewerCore\Git
 */
class BranchNotFound extends FileNotFound
{
    /**
     * BranchNotFound constructor.
     * @param string $branch
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $branch, $code = 0, Throwable $previous = null)
    {
        $message = "Git Branch '{$branch}' Not Found";

        parent::__construct($message, $code, $previous);
    }
}
