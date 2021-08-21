<?php

namespace ArtARTs36\GitHandler\Support;

use ArtARTs36\FileSystem\Contracts\FileSystem;
use ArtARTs36\GitHandler\Contracts\PathGenerator;
use ArtARTs36\GitHandler\Enum\ArchiveFormat;

class TemporaryPathGenerator implements PathGenerator
{
    protected $files;

    public function __construct(FileSystem $files)
    {
        $this->files = $files;
    }

    public function toArchive(ArchiveFormat $format): string
    {
        return $this->files->getTmpDir()
            . DIRECTORY_SEPARATOR
            . $this->buildArchiveName()
            . '.' . $format->value;
    }

    protected function buildArchiveName(): string
    {
        return implode('-', [
            'git',
            'handler',
            time(),
            'archive',
        ]);
    }
}
