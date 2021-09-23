<?php

namespace ArtARTs36\GitHandler\Exceptions;

use Throwable;

class ConfigSectionNotFound extends GitHandlerException
{
    public $failedConfigSection;

    public function __construct(string $failedConfigSection)
    {
        $this->failedConfigSection = $failedConfigSection;

        parent::__construct("Key does not contain a section: $failedConfigSection");
    }
}
