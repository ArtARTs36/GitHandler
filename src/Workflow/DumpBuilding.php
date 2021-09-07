<?php

namespace ArtARTs36\GitHandler\Workflow;

use ArtARTs36\GitHandler\Contracts\Workflow\WorkflowElement;
use ArtARTs36\GitHandler\Workflow\Elements\ConfigWorkflowElement;
use ArtARTs36\GitHandler\Workflow\Elements\HookWorkflowElement;
use ArtARTs36\GitHandler\Workflow\Elements\UntrackedFilesWorkflowElement;

class DumpBuilding implements \IteratorAggregate
{
    protected $elements = [];

    public function all(): self
    {
        $this->withHooks()->withConfig()->withUntrackedFiles();

        return $this;
    }

    public function withHooks(): self
    {
        return $this->with(new HookWorkflowElement());
    }

    public function withConfig(): self
    {
        return $this->with(new ConfigWorkflowElement());
    }

    public function withUntrackedFiles(): self
    {
        return $this->with(new UntrackedFilesWorkflowElement());
    }

    public function with(WorkflowElement $element, WorkflowElement ...$elements): self
    {
        $this->elements = array_merge($this->elements, [$element], $elements);

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
}
