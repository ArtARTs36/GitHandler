<?php

namespace ArtARTs36\GitHandler\Exceptions;

use Throwable;

class UnexpectedException extends GitHandlerException
{
    public function __construct(string $command, $code = 0, Throwable $previous = null)
    {
        $message = "Unexpected exception after execution command: ". $command;

        parent::__construct($message, $code, $previous);
    }
}
