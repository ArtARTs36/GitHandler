<?php

namespace ArtARTs36\GitHandler\Exceptions;

class RemoteRepositoryNotFound extends GitHandlerException
{
    public $errorRemoteRepository;

    public function __construct(string $errorRemoteRepository)
    {
        $this->errorRemoteRepository = $errorRemoteRepository;

        parent::__construct("Remote Repository $errorRemoteRepository not found");
    }
}
