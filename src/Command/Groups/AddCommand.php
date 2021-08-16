<?php

namespace ArtARTs36\GitHandler\Command\Groups;

use ArtARTs36\GitHandler\Command\Groups\Contracts\GitAddCommand;
use ArtARTs36\GitHandler\Exceptions\FileNotFound;
use ArtARTs36\ShellCommand\Exceptions\UserExceptionTrigger;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\Result\CommandResult;
use ArtARTs36\Str\Str;

class AddCommand extends AbstractCommand implements GitAddCommand
{
    /**
     * @inheritDoc
     */
    public function add($file, bool $force = false): bool
    {
        $files = (array) $file;

        return $this
            ->builder
            ->make()
            ->addArgument('add')
            ->addArguments($files)
            ->when($force, function (ShellCommandInterface $command) {
                $command->addOption('force');
            })
            ->setExceptionTrigger(UserExceptionTrigger::fromCallbacks([
                function (CommandResult $result) use ($files) {
                    FileNotFound::handleIfSo(Str::fromArray($files, ','), $result->getError());
                }
            ]))
            ->executeOrFail($this->executor)
            ->isOk();
    }
}
