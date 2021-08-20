<?php

namespace ArtARTs36\GitHandler\Contracts\Commands;

interface GitMergeCommand
{
    public function mergeWithBranch(string $branch): void;
}
