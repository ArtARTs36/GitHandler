<?php

namespace ArtARTs36\GitHandler\Contracts\Workflow;

interface ReplenishedWorkflowBuilding
{
    /**
     * @return $this
     */
    public function with(WorkflowElement $element, WorkflowElement ...$elements);
}
