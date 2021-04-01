<?php

namespace ArtARTs36\GitHandler\Exceptions;

use Throwable;

class RemoteNotFound extends GitHandlerException
{
    public $remoteName;

    public function __construct(string $remoteName, $code = 0, Throwable $previous = null)
    {
        $this->remoteName = $remoteName;

        $message = "No such remote: $remoteName";

        parent::__construct($message, $code, $previous);
    }
}
