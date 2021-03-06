<?php

namespace ArtARTs36\GitHandler\Exceptions;

use ArtARTs36\Str\Str;

class FileNotFound extends GitHandlerException
{
    public function __construct(string $file)
    {
        $message = "File '{$file}' Not Found";

        parent::__construct($message);
    }

    /**
     * @codeCoverageIgnore
     */
    public static function patternStdError(string $file): string
    {
        return "pathspec '{$file}' did not match any";
    }

    public static function handleIfSo(string $file, Str $stdout): void
    {
        if ($stdout->contains(static::patternStdError($file))) {
            throw new static($file);
        }
    }
}
