<?php

namespace ArtARTs36\GitHandler\Command\Groups;

use ArtARTs36\GitHandler\Command\Groups\Contracts\GitHelpCommandGroup;

class HelpCommand extends AbstractCommand implements GitHelpCommandGroup
{
    public function get(): string
    {
        return $this->builder->make()->addOption('help')->executeOrFail($this->executor);
    }
}
