<?php

namespace ArtARTs36\GitHandler\Exceptions;

use Throwable;

class ConfigDataNotFound extends GitHandlerException
{
    public $errorPrefix;

    public function __construct(string $prefix, $code = 0, Throwable $previous = null)
    {
        $this->errorPrefix = $prefix;

        $message = "Config Data by prefix $prefix not found";

        parent::__construct($message, $code, $previous);
    }
}
