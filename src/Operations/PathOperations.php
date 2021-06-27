<?php

namespace ArtARTs36\GitHandler\Operations;

use ArtARTs36\GitHandler\Exceptions\UnexpectedException;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\ShellCommand;
use ArtARTs36\Str\Str;

trait PathOperations
{
    abstract protected function newCommand(?string $dir = null): ShellCommandInterface;

    abstract protected function executeCommand(ShellCommand $command): ?Str;

    public function getInfoPath(): string
    {
        return $this->getPathByOption('info-path');
    }

    public function getHtmlPath(): string
    {
        return $this->getPathByOption('html-path');
    }

    public function getManPath(): string
    {
        return $this->getPathByOption('man-path');
    }

    protected function getPathByOption(string $option): string
    {
        $result = $this->executeCommand($cmd = $this->newCommand()->addOption($option));

        if ($result === null || $result->isEmpty()) {
            throw new UnexpectedException($cmd);
        }

        return $result->trim();
    }
}
