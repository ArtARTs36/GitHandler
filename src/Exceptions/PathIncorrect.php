<?php

namespace ArtARTs36\GitHandler\Exceptions;

class PathIncorrect extends GitHandlerException
{
    public $incorrectPath;

    public function __construct(string $path)
    {
        $this->incorrectPath = $path;

        $message = "Path {$path} incorrect!";

        parent::__construct($message);
    }
}
