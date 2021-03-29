<?php

namespace ArtARTs36\GitHandler\Exceptions;

use Throwable;

class ConfigDataNotFound extends \LogicException
{
    public function __construct(string $prefix, $code = 0, Throwable $previous = null)
    {
        $message = "Config Data by prefix $prefix not found";

        parent::__construct($message, $code, $previous);
    }
}
