<?php

namespace ArtARTs36\GitHandler\Operations;

use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\ShellCommand;
use ArtARTs36\Str\Str;

trait PathOperations
{
    abstract protected function newCommand(?string $dir = null): ShellCommandInterface;

    abstract protected function executeCommand(ShellCommand $command): ?Str;

    public function getInfoPath(): string
    {
        return $this->executeCommand($this->newCommand()->addOption('info-path'))->trim();
    }

    public function getHtmlPath(): string
    {
        return $this->executeCommand($this->newCommand()->addOption('info-path'))->trim();
    }

    public function getManPath(): string
    {
        return $this->executeCommand($this->newCommand()->addOption('man-path'))->trim();
    }
}
