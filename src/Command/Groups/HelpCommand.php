<?php

namespace ArtARTs36\GitHandler\Command\Groups;

use ArtARTs36\GitHandler\Command\Groups\Contracts\GitHelpCommand;

class HelpCommand extends AbstractCommand implements GitHelpCommand
{
    public function get(): string
    {
        return $this->builder->make()->addOption('help')->executeOrFail($this->executor);
    }
}
