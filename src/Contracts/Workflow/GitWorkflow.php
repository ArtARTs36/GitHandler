<?php

namespace ArtARTs36\GitHandler\Contracts\Workflow;

/**
 * Git Workflow (dump and restore git features)
 */
interface GitWorkflow
{
    /**
     * Dump workflow
     */
    public function dump(string $path): void;

    /**
     * Restore workflow
     */
    public function restore(string $path): void;
}
