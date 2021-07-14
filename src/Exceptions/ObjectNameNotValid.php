<?php

namespace ArtARTs36\GitHandler\Exceptions;

use JetBrains\PhpStorm\Immutable;
use Throwable;

class ObjectNameNotValid extends GitHandlerException
{
    #[Immutable]
    public $errorObjectName;

    public function __construct(string $objectName)
    {
        $this->errorObjectName = $objectName;

        parent::__construct("Not a valid object name: '$objectName'");
    }
}
