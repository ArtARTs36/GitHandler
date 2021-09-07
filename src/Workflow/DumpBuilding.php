<?php

namespace ArtARTs36\GitHandler\Workflow;

use ArtARTs36\GitHandler\Contracts\Workflow\WorkflowElement;
use ArtARTs36\GitHandler\Workflow\Elements\ConfigWorkflowElement;
use ArtARTs36\GitHandler\Workflow\Elements\HookWorkflowElement;

class DumpBuilding implements \IteratorAggregate
{
    protected $elements = [];

    public function withHooks(): self
    {
        $this->elements[] = new HookWorkflowElement();

        return $this;
    }

    public function withConfig(): self
    {
        $this->elements[] = new ConfigWorkflowElement();

        return $this;
    }

    public function defaults(): self
    {
        return $this->withConfig()->withHooks();
    }

    public function bind(callable $callback): self
    {
        $callback($this);

        return $this;
    }

    /**
     * @return iterable<WorkflowElement>
     */
    public function getIterator(): iterable
    {
        return new \ArrayIterator($this->elements);
    }

    public function __invoke(): self
    {
        return $this;
    }
}
