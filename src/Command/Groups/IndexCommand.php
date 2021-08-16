<?php

namespace ArtARTs36\GitHandler\Command\Groups;

use ArtARTs36\GitHandler\Command\Groups\Contracts\GitIndexCommand;
use ArtARTs36\GitHandler\Exceptions\FileNotFound;
use ArtARTs36\ShellCommand\Exceptions\UserExceptionTrigger;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\Result\CommandResult;
use ArtARTs36\Str\Str;

class IndexCommand extends AbstractCommand implements GitIndexCommand
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

    public function remove($files, bool $force = false): bool
    {
        return $this
            ->builder
            ->make()
            ->addArgument('rm')
            ->addArguments((array) $files)
            ->when($force, function (ShellCommandInterface $command) {
                $command->addOption('force');
            })
            ->executeOrFail($this->executor)
            ->isOk();
    }
}
