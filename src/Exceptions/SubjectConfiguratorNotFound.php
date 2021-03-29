<?php

namespace ArtARTs36\GitHandler\Exceptions;

use Throwable;

class SubjectConfiguratorNotFound extends GitHandlerException
{
    public function __construct(string $prefix, $code = 0, Throwable $previous = null)
    {
        $message = "Subject Configurator by prefix $prefix not found";

        parent::__construct($message, $code, $previous);
    }
}
