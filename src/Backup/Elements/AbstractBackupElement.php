<?php

namespace ArtARTs36\GitHandler\Backup\Elements;

use ArtARTs36\GitHandler\Contracts\Backup\BackupElement;

abstract class AbstractBackupElement implements BackupElement
{
    public const IDENTITY = '';

    /**
     * @codeCoverageIgnore
     */
    public function identity(): string
    {
        return static::IDENTITY;
    }
}
