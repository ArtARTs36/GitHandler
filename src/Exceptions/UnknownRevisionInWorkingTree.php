<?php

namespace ArtARTs36\GitHandler\Exceptions;

/**
 * Unknown revision or path not in the working tree
 */
class UnknownRevisionInWorkingTree extends GitHandlerException
{
    public $failedRevisionOrPath;

    public function __construct(string $revisionOrPath)
    {
        $this->failedRevisionOrPath = $revisionOrPath;

        parent::__construct("$revisionOrPath: unknown revision or path not in the working tree.");
    }
}
