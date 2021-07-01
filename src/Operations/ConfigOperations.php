<?php

namespace ArtARTs36\GitHandler\Operations;

use ArtARTs36\GitHandler\Config\Subjects\SubjectsCollection;
use ArtARTs36\GitHandler\Contracts\ConfigResultParser;
use ArtARTs36\GitHandler\Contracts\ConfigSubject;
use ArtARTs36\GitHandler\Exceptions\UnexpectedException;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\ShellCommand;
use ArtARTs36\Str\Str;

trait ConfigOperations
{
    abstract protected function newCommand(?string $dir = null): ShellCommandInterface;

    abstract protected function executeCommand(ShellCommand $command): ?Str;

    abstract protected function getConfigReader(): ConfigResultParser;

    public function getConfigList(): SubjectsCollection
    {
        return $this->getConfigReader()->parse($this->executeConfigList());
    }

    /**
     * @inheritDoc
     */
    public function getConfigSubject(string $prefix): ConfigSubject
    {
        return $this->getConfigReader()->parseByPrefix($this->executeConfigList(), $prefix);
    }

    public function setConfig(string $scope, string $field, string $value, bool $replaceAll = false): bool
    {
        $result = $this->executeCommand(
            $cmd = $this->newCommand()
                    ->addParameter('config')
                    ->addParameter("$scope.$field")
                    ->addParameter($value, true)
                    ->when($replaceAll === true, function (ShellCommandInterface $command) {
                        $command->addOption('replace-all');
                    })
        );

        if ($result === null) {
            return true;
        }

        throw new UnexpectedException($cmd);
    }

    protected function executeConfigList(): Str
    {
        return $this->executeCommand($this->newCommand()->addParameter('config')->addOption('list'));
    }
}
