<?php

namespace ArtARTs36\GitHandler\Command\Commands;

use ArtARTs36\GitHandler\Command\GitCommandBuilder;
use ArtARTs36\GitHandler\Contracts\Commands\GitConfigCommand;
use ArtARTs36\GitHandler\Config\Subjects\SubjectsCollection;
use ArtARTs36\GitHandler\Contracts\Config\ConfigResultParser;
use ArtARTs36\GitHandler\Contracts\Config\ConfigSubject;
use ArtARTs36\GitHandler\Exceptions\ConfigSectionNotFound;
use ArtARTs36\GitHandler\Exceptions\ConfigVariableNotFound;
use ArtARTs36\ShellCommand\Exceptions\UserExceptionTrigger;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandExecutor;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\Result\CommandResult;
use ArtARTs36\Str\Str;

class ConfigCommand extends AbstractCommand implements GitConfigCommand
{
    protected $reader;

    public function __construct(ConfigResultParser $reader, GitCommandBuilder $builder, ShellCommandExecutor $executor)
    {
        $this->reader = $reader;

        parent::__construct($builder, $executor);
    }

    public function getAll(): SubjectsCollection
    {
        return $this->reader->parse($this->executeConfigList());
    }

    public function getSubject(string $prefix): ConfigSubject
    {
        return $this->reader->parseByPrefix($this->executeConfigList(), $prefix);
    }

    public function set(string $scope, string $field, string $value, bool $replaceAll = false): bool
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

    public function unset(string $scope, string $field): void
    {
        $this
            ->builder
            ->make()
            ->addArgument('config')
            ->addOption('unset')
            ->addArgument("$scope.$field")
            ->setExceptionTrigger(UserExceptionTrigger::fromCallbacks([
                function (CommandResult $result) {
                    $error = $result->getError()->trim();

                    $section = $error->match('#key does not contain a section: (.*)#');

                    if ($section->isNotEmpty()) {
                        throw new ConfigSectionNotFound($section);
                    }

                    $variable = $error->match('#key does not contain variable name: (.*)#');

                    if ($variable->isNotEmpty()) {
                        throw new ConfigVariableNotFound($variable);
                    }
                },
            ]))
            ->executeOrFail($this->executor);
    }
}
