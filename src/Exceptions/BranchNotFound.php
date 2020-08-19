<?php

namespace ArtARTs36\GitHandler\Exceptions;

use ArtARTs36\GitHandler\Support\Str;
use Throwable;

/**
 * Class BranchNotFound
 * @package ArtARTs36\HostReviewerCore\Git
 */
class BranchNotFound extends \LogicException
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

    /**
     * @param string $branch
     * @return string
     */
    public static function patternStdError(string $branch): string
    {
        return "pathspec '{$branch}' did not match any";
    }

    /**
     * @param string $branch
     * @param string $stdout
     */
    public static function handleIfSo(string $branch, string $stdout): void
    {
        if (Str::contains(static::patternStdError($branch), $stdout)) {
            throw new static($branch);
        }
    }
}
