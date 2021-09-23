<?php

namespace ArtARTs36\GitHandler\Contracts\Workflow;

use ArtARTs36\GitHandler\Contracts\Handler\GitHandler;

interface BackupElement
{
    public function dump(GitHandler $git): array;

    public function restore(GitHandler $git, array $data): void;

    /**
     * Get this backup element identifier
     */
    public function identity(): string;
}
