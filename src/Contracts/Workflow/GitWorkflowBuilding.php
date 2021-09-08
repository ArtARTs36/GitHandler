<?php

namespace ArtARTs36\GitHandler\Contracts\Workflow;

interface GitWorkflowBuilding extends \IteratorAggregate, ReplenishedWorkflowBuilding
{
    /**
     * @param array<class-string<WorkflowElement>> $classes
     * @return array<WorkflowElement>
     */
    public function get(array $classes): array;

    /**
     * @return static
     */
    public function only(array $classes);

    /**
     * @return iterable<WorkflowElement>
     */
    public function getIterator();
}
