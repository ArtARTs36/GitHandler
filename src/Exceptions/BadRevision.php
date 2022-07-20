<?php

namespace ArtARTs36\GitHandler\Exceptions;

class BadRevision extends GitHandlerException
{
    public $failedRevision;

    public function __construct(string $failedRevision)
    {
        $this->failedRevision = $failedRevision;

        parent::__construct("Bad revision: $failedRevision");
    }
}
