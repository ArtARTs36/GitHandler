<?php

namespace ArtARTs36\GitHandler\Exceptions;

use ArtARTs36\Str\Str;

class PathAlreadyExists extends GitHandlerException
{
    public $errorPath;

    public function __construct(string $path)
    {
        $this->errorPath = $path;

        $message = "Path '$path' already exists";

        parent::__construct($message);
    }

    /**
     * @codeCoverageIgnore
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
