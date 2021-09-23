<?php

namespace ArtARTs36\GitHandler\Backup\Elements;

use ArtARTs36\GitHandler\Contracts\Workflow\WorkflowElement;

abstract class AbstractWorkflowElement implements WorkflowElement
{
    public const IDENTITY = '';

    /**
     * @codeCoverageIgnore
     */
    public function identity(): string
    {
        return static::IDENTITY;
    }
}
