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

    /**
     * @codeCoverageIgnore
     */
    public static function patternStdErrorOnAnyFile(): string
    {
        return "/pathspec '(.*)' did not match any/i";
    }

    /**
     * @codeCoverageIgnore
     */
    public static function handleIfSoOnAnyFile(Str $err): void
    {
        if (($path = $err->match(static::patternStdErrorOnAnyFile())) &&
            $err->isNotEmpty()) {
            throw new static($path);
        }
    }

    public static function handleIfSo(string $file, Str $stdout): void
    {
        if ($stdout->contains(static::patternStdError($file))) {
            throw new static($file);
        }
    }
}
