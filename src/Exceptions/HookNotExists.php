<?php

namespace ArtARTs36\GitHandler\Exceptions;

class HookNotExists extends GitHandlerException
{
    public $errorHookName;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(string $errorHookName)
    {
        $this->errorHookName = $errorHookName;

        parent::__construct("Hook $errorHookName not exists!");
    }
}
