<?php

namespace ArtARTs36\GitHandler\Exceptions;

class SubmoduleNotFound extends GitHandlerException
{
    public $failedSubmoduleName;

    public function __construct(string $failedSubmoduleName)
    {
        parent::__construct('Module '. $failedSubmoduleName . ' not found!');
    }
}
