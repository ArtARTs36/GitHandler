<?php

namespace ArtARTs36\GitHandler\Tests\Support;

use ArtARTs36\GitHandler\Contracts\Backup\BackupElement;
use ArtARTs36\GitHandler\Contracts\Handler\GitHandler;

class IsCalledBackupElement implements BackupElement
{
    public $name;

    public $isCalled = false;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function dump(GitHandler $git): array
    {
        $this->isCalled = true;

        return [];
    }

    public function restore(GitHandler $git, array $data): void
    {
        $this->isCalled = true;
    }

    public function identity(): string
    {
        return $this->name;
    }
}
