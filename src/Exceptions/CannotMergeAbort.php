<?php

namespace ArtARTs36\GitHandler\Exceptions;

class CannotMergeAbort extends GitHandlerException
{
    public function __construct(string $reason)
    {
        $message = 'fatal: There is no merge to abort ('. $reason . ')';

        parent::__construct($message);
    }
}
