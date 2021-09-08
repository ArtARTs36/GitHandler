<?php

namespace ArtARTs36\GitHandler\Contracts\Workflow;

/**
 * Git Workflow (dump and restore git features)
 */
interface GitWorkflow
{
    /**
     * Setup for dump & restore building
     * @return $this
     */
    public function building(callable $callback);

    /**
     * Dump workflow
     */
    public function dump(string $path): void;

    /**
     * Dump workflow
     * @param non-empty-list<class-string<WorkflowElement>|string> $elements
     */
    public function dumpOnly(string $path, array $elements): void;

    /**
     * Restore workflow
     */
    public function restore(string $path): void;
}
