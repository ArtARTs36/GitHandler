<?php

namespace ArtARTs36\GitHandler\Command\Commands;

use ArtARTs36\GitHandler\Contracts\Commands\GitSubmoduleCommand;

class SubmoduleCommand extends AbstractCommand implements GitSubmoduleCommand
{
    public function add(string $url): void
    {
        $this
            ->builder
            ->make()
            ->addArgument('submodule')
            ->addArgument('add')
            ->addArgument($url)
            ->executeOrFail($this->executor);
    }
}
