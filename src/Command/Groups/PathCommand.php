<?php

namespace ArtARTs36\GitHandler\Command\Groups;

use ArtARTs36\GitHandler\Command\Groups\Contracts\GitPathCommand;

class PathCommand extends AbstractCommand implements GitPathCommand
{
    public function info(): string
    {
        return $this->getPathByOption('info-path');
    }

    public function html(): string
    {
        return $this->getPathByOption('html-path');
    }

    public function man(): string
    {
        return $this->getPathByOption('man-path');
    }

    protected function getPathByOption(string $option): string
    {
        return $this->builder->make()->addOption($option)->executeOrFail($this->executor)->getResult()->trim();
    }
}
