<?php

namespace ArtARTs36\GitHandler\Exceptions;

class ReferenceInvalid extends GitHandlerException
{
    public $errorReference;

    public function __construct(string $errorReference)
    {
        $this->errorReference = $errorReference;

        parent::__construct("Invalid reference: ". $errorReference);
    }
}
