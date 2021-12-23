<?php

namespace ArtARTs36\GitHandler\Exceptions;

final class TagAlreadyExists extends GitHandlerException
{
    public function __construct(string $tag)
    {
        $message = "Tag \"{$tag}\" already exists!";

        parent::__construct($message);
    }
}
