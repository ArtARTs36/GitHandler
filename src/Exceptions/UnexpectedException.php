<?php

namespace ArtARTs36\GitHandler\Exceptions;

class UnexpectedException extends GitHandlerException
{
    public $errorCommand;

    public function __construct(string $command)
    {
        $this->errorCommand = $command;

        $message = "Unexpected exception after execution command: ". $command;

        parent::__construct($message);
    }
}
