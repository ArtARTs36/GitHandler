<?php

namespace ArtARTs36\GitHandler\Workflow;

use ArtARTs36\GitHandler\Contracts\Workflow\GitWorkflowBuilding;
use ArtARTs36\GitHandler\Contracts\Workflow\WorkflowElement;
use ArtARTs36\GitHandler\Workflow\Elements\ConfigCommitWorkflowElement;
use ArtARTs36\GitHandler\Workflow\Elements\HookWorkflowElement;
use ArtARTs36\GitHandler\Workflow\Elements\UntrackedFilesWorkflowElement;

class WorkflowBuilding implements GitWorkflowBuilding
{
    protected $elements = [];

    /**
     * @param list<WorkflowElement> $elements
     */
    public function __construct(array $elements = [])
    {
        $this->elements = $elements;
    }

    public function with(WorkflowElement $element, WorkflowElement ...$elements): self
    {
        $this->elements = array_merge($this->elements, [$element], $elements);

        return $this;
    }

    /**
     * @return iterable<WorkflowElement>
     */
    public function getIterator(): iterable
    {
        return new \ArrayIterator($this->elements);
    }

    public function get(array $classes): array
    {
        $elems = [];

        foreach ($this->elements as $element) {
            if (in_array($element->identity(), $classes) || in_array(get_class($element), $classes)) {
                $elems[] = $element;
            }
        }

        return $elems;
    }

    public function only(array $classes): self
    {
        $elements = $this->get($classes);

        assert(count($elements) > 0, new \LogicException('Not found workflow elements'));

        return new self($elements);
    }
}