<?php

namespace ArtARTs36\GitHandler\Exceptions;

use Throwable;

class RemoteAlreadyExists extends GitHandlerException
{
    public $remoteName;

    public function __construct(string $remoteName, $code = 0, Throwable $previous = null)
    {
        $this->remoteName = $remoteName;

        $message = "Remote $remoteName already exists";

        parent::__construct($message, $code, $previous);
    }
}
