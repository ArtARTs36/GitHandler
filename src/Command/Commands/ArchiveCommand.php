<?php

namespace ArtARTs36\GitHandler\Command\Commands;

use ArtARTs36\GitHandler\Command\Commands\Contracts\GitArchiveCommand;
use ArtARTs36\GitHandler\Enum\ArchiveFormat;
use ArtARTs36\GitHandler\Exceptions\PathIsDirectoryNotCould;
use ArtARTs36\ShellCommand\Exceptions\UserExceptionTrigger;
use ArtARTs36\ShellCommand\Result\CommandResult;

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
            ->setExceptionTrigger(UserExceptionTrigger::fromCallbacks([
                function (CommandResult $result) use ($path) {
                    if ($result
                        ->getError()
                        ->contains("fatal: could not create archive file '$path': Is a directory")) {
                        throw new PathIsDirectoryNotCould();
                    }
                }
            ]))
            ->executeOrFail($this->executor);
    }
}
