<?php

namespace ArtARTs36\GitHandler\Command\Commands;

use ArtARTs36\GitHandler\Contracts\Commands\GitHelpCommand;

class HelpCommand extends AbstractCommand implements GitHelpCommand
{
    public function get(): string
    {
        return $this->builder->make()->addOption('help')->executeOrFail($this->executor);
    }
}
