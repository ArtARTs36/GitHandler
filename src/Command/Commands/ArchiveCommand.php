<?php

namespace ArtARTs36\GitHandler\Command\Commands;

use ArtARTs36\GitHandler\Command\Commands\Contracts\GitArchiveCommand;
use ArtARTs36\GitHandler\Enum\ArchiveFormat;

class ArchiveCommand extends AbstractCommand implements GitArchiveCommand
{
    public function create(string $path): void
    {
        $this
            ->builder
            ->make()
            ->addArgument('archive')
            ->addOptionWithValue('format', ArchiveFormat::from(pathinfo($path, PATHINFO_EXTENSION))->value)
            ->addOptionWithValue('output', $path)
            ->addArgument('HEAD')
            ->executeOrFail($this->executor);
    }
}
