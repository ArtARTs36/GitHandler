<?php

namespace ArtARTs36\GitHandler\Exceptions;

class CannotMergeException extends GitHandlerException
{
    public $failedMergeBranch;
}
