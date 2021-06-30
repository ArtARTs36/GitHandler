<?php

namespace ArtARTs36\GitHandler\Exceptions;

class ConfigDataNotFound extends GitHandlerException
{
    public $errorPrefix;

    public function __construct(string $prefix)
    {
        $this->errorPrefix = $prefix;

        $message = "Config Data by prefix $prefix not found";

        parent::__construct($message);
    }
}
