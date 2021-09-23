<?php

namespace ArtARTs36\GitHandler\Tests\Support;

use ArtARTs36\GitHandler\Contracts\Handler\GitHandler;
use ArtARTs36\GitHandler\Contracts\Workflow\BackupElement;

class TestBackupElement implements BackupElement
{
    private $dumpResult;

    public function __construct(array $dumpResult = [])
    {
        $this->dumpResult = $dumpResult;
    }

    public function dump(GitHandler $git): array
    {
        return $this->dumpResult;
    }

    public function restore(GitHandler $git, array $data): void
    {
        //
    }

    public function identity(): string
    {
        return 'test-element';
    }
}
