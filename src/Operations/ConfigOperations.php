<?php

namespace ArtARTs36\GitHandler\Operations;

use ArtARTs36\GitHandler\Config\ConfigReader;
use ArtARTs36\GitHandler\Contracts\ConfigSubject;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\ShellCommand;

trait ConfigOperations
{
    abstract protected function newCommand(?string $dir = null): ShellCommandInterface;

    abstract protected function executeCommand(ShellCommand $command): ?string;

    abstract protected function getConfigReader(): ConfigReader;

    public function getConfigList(): array
    {
        return $this->getConfigReader()->parse($this->executeConfigList());
    }

    public function getConfigSubject(string $prefix): ConfigSubject
    {
        return $this->getConfigReader()->parseByPrefix($this->executeConfigList(), $prefix);
    }

    public function setConfig(string $scope, string $field, string $value): bool
    {
        return $this->executeCommand(
            $this->newCommand()
                    ->addParameter('config')
                    ->addParameter("$scope.$field")
                    ->addParameter('=')
                    ->addParameter($value, true)
        ) !== null;
    }

    protected function executeConfigList(): string
    {
        return $this->executeCommand($this->newCommand()->addParameter('config')->addOption('list'));
    }
}
