<?php

namespace ArtARTs36\GitHandler\Exceptions;

use Throwable;

class PathIncorrect extends GitHandlerException
{
    public function __construct(string $path, $code = 0, Throwable $previous = null)
    {
        $message = "Path {$path} incorrect!";

        parent::__construct($message, $code, $previous);
    }
}
