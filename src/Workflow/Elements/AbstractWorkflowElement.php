<?php

namespace ArtARTs36\GitHandler\Workflow\Elements;

use ArtARTs36\GitHandler\Contracts\Workflow\WorkflowElement;

abstract class AbstractWorkflowElement implements WorkflowElement
{
    public const IDENTITY = '';

    public function identity(): string
    {
        return static::IDENTITY;
    }
}
