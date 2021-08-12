<?php

namespace ArtARTs36\GitHandler\Command\Groups;

use ArtARTs36\GitHandler\Command\Groups\Contracts\GitHelpCommandGroup;

class HelpCommandGroup extends AbstractCommandGroup implements GitHelpCommandGroup
{
    public function get(): string
    {
        return $this->builder->make()->addOption('help')->executeOrFail($this->executor);
    }
}
