<?php

namespace ArtARTs36\GitHandler\Exceptions;

class RemoteNotFound extends GitHandlerException
{
    public $remoteName;

    public function __construct(string $remoteName)
    {
        $this->remoteName = $remoteName;

        parent::__construct("No such remote: $remoteName");
    }
}
