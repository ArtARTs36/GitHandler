<?php

namespace ArtARTs36\GitHandler\Exceptions;

use ArtARTs36\Str\Str;
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

    public static function handleIfSo(string $path, Str $stdout): void
    {
        if ($stdout->contains(static::patternStdError($path))) {
            throw new static($path);
        }
    }
}
