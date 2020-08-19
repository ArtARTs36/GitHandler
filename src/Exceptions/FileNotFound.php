<?php

namespace ArtARTs36\GitHandler\Exceptions;

use ArtARTs36\GitHandler\Support\Str;
use Throwable;

/**
 * Class FileNotFound
 * @package ArtARTs36\GitHandler\Exceptions
 */
class FileNotFound extends \LogicException
{
    /**
     * BranchNotFound constructor.
     * @param string $file
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $file, $code = 0, Throwable $previous = null)
    {
        $message = "File '{$file}' Not Found";

        parent::__construct($message, $code, $previous);
    }

    /**
     * @param string $file
     * @return string
     */
    public static function patternStdError(string $file): string
    {
        return "pathspec '{$file}' did not match any";
    }

    /**
     * @param string $file
     * @param string $stdout
     */
    public static function handleIfSo(string $file, string $stdout): void
    {
        if (Str::contains($stdout, static::patternStdError($file))) {
            throw new static($file);
        }
    }
}
