<?php

namespace ArtARTs36\GitHandler\Exceptions;

class StashDoesNotExists extends GitHandlerException
{
    public $errorStashId;

    public function __construct(int $errorStashId)
    {
        $this->errorStashId = $errorStashId;

        parent::__construct("Stash by id $errorStashId does not exists!");
    }
}
