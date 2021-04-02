<?php

namespace ArtARTs36\GitHandler\Exceptions;

use Throwable;

class PathIncorrect extends GitHandlerException
{
    public $incorrectPath;

    public function __construct(string $path, $code = 0, Throwable $previous = null)
    {
        $this->incorrectPath = $path;

        $message = "Path {$path} incorrect!";

        parent::__construct($message, $code, $previous);
    }
}
