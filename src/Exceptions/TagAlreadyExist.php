<?php

namespace ArtARTs36\GitHandler\Exceptions;

use Throwable;

final class TagAlreadyExist extends \LogicException
{
    public function __construct($tag, $code = 0, Throwable $previous = null)
    {
        $message = "Tag \"{$tag}\" already exist!";

        parent::__construct($message, $code, $previous);
    }
}
