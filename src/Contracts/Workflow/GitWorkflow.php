<?php

namespace ArtARTs36\GitHandler\Contracts\Workflow;

interface GitWorkflow
{
    public function dump(string $path): void;

    public function restore(string $path): void;
}
