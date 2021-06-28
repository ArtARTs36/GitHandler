<?php

namespace ArtARTs36\GitHandler\Exceptions;

use Throwable;

class UnexpectedException extends GitHandlerException
{
    public $errorCommand;

    public function __construct(string $command, $code = 0, Throwable $previous = null)
    {
        $this->errorCommand = $command;

        $message = "Unexpected exception after execution command: ". $command;

        parent::__construct($message, $code, $previous);
    }
}
