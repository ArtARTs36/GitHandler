<?php

namespace ArtARTs36\GitHandler\Command\Groups;

use ArtARTs36\GitHandler\Command\GitCommandBuilder;
use ArtARTs36\GitHandler\Command\Groups\Contracts\GitConfigCommand;
use ArtARTs36\GitHandler\Config\Subjects\SubjectsCollection;
use ArtARTs36\GitHandler\Contracts\ConfigResultParser;
use ArtARTs36\GitHandler\Contracts\ConfigSubject;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandExecutor;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\Str\Str;

class ConfigCommand extends AbstractCommandGroup implements GitConfigCommand
{
    protected $reader;

    public function __construct(ConfigResultParser $reader, GitCommandBuilder $builder, ShellCommandExecutor $executor)
    {
        $this->reader = $reader;

        parent::__construct($builder, $executor);
    }

    public function getConfigList(): SubjectsCollection
    {
        return $this->reader->parse($this->executeConfigList());
    }

    /**
     * @inheritDoc
     */
    public function getConfigSubject(string $prefix): ConfigSubject
    {
        return $this->reader->parseByPrefix($this->executeConfigList(), $prefix);
    }

    public function setConfig(string $scope, string $field, string $value, bool $replaceAll = false): bool
    {
        return $this
            ->builder
            ->make()
            ->addArgument('config')
            ->addArgument("$scope.$field")
            ->addArgument($value, true)
            ->when($replaceAll === true, function (ShellCommandInterface $command) {
                $command->addOption('replace-all');
            })
            ->executeOrFail($this->executor)
            ->isOk();
    }

    protected function executeConfigList(): Str
    {
        return $this
            ->builder
            ->make()
            ->addArgument('config')
            ->addOption('list')
            ->executeOrFail($this->executor)
            ->getResult();
    }
}
