<?php

namespace ArtARTs36\GitHandler\Exceptions;

use Throwable;

final class TagAlreadyExists extends GitHandlerException
{
    public function __construct($tag)
    {
        $message = "Tag \"{$tag}\" already exists!";

        parent::__construct($message);
    }
}
