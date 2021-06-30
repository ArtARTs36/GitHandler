<?php

namespace ArtARTs36\GitHandler\Exceptions;

class SubjectConfiguratorNotFound extends GitHandlerException
{
    public function __construct(string $prefix)
    {
        $message = "Subject Configurator by prefix $prefix not found";

        parent::__construct($message);
    }
}
