<?php

namespace ArtARTs36\GitHandler\Exceptions;

class RemoteAlreadyExists extends GitHandlerException
{
    public $remoteName;

    public function __construct(string $remoteName)
    {
        $this->remoteName = $remoteName;

        $message = "Remote $remoteName already exists";

        parent::__construct($message);
    }
}
