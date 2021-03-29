<?php

namespace ArtARTs36\GitHandler\Exceptions;

use ArtARTs36\Str\Facade\Str;
use Throwable;

class PathAlreadyExists extends GitHandlerException
{
    public function __construct(string $path, $code = 0, Throwable $previous = null)
    {
        $message = "Path {$path} already exists";

        parent::__construct($message, $code, $previous);
    }

    /**
     * @param string $path
     * @return string
     */
    public static function patternStdError(string $path): string
    {
        return "destination path '{$path}' already exists";
    }

    /**
     * @param string $path
     * @param string $stdout
     */
    public static function handleIfSo(string $path, string $stdout): void
    {
        if (Str::contains($stdout, static::patternStdError($path))) {
            throw new static($path);
        }
    }
}
