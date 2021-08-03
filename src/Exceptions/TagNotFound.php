<?php

namespace ArtARTs36\GitHandler\Exceptions;

use Throwable;

class TagNotFound extends GitHandlerException
{
    public $errorTag;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(string $errorTag)
    {
        $this->errorTag = $errorTag;

        parent::__construct("Tag '$errorTag' not found!");
    }
}
