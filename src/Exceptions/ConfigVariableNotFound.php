<?php

namespace ArtARTs36\GitHandler\Exceptions;

final class ConfigVariableNotFound extends GitHandlerException
{
    public $failedConfigVariable;

    public function __construct(string $failedConfigVariable)
    {
        $this->failedConfigVariable = $failedConfigVariable;

        parent::__construct("key does not contain a section: $failedConfigVariable");
    }
}
