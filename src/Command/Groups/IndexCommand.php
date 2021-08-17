<?php

namespace ArtARTs36\GitHandler\Command\Groups;

use ArtARTs36\GitHandler\Command\Groups\Contracts\GitIndexCommand;
use ArtARTs36\GitHandler\Enum\ResetMode;
use ArtARTs36\GitHandler\Exceptions\FileNotFound;
use ArtARTs36\GitHandler\Exceptions\UnknownRevisionInWorkingTree;
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

    public function reset(ResetMode $mode, string $subject): bool
    {
        return $this
            ->builder
            ->make()
            ->addArgument('reset')
            ->addOption($mode->value)
            ->addArgument($subject)
            ->setExceptionTrigger(UserExceptionTrigger::fromCallbacks([
                function (CommandResult $result) use ($subject) {
                    if ($result->getError()->contains('unknown revision or path not in the working tree')) {
                        throw new UnknownRevisionInWorkingTree($subject);
                    }
                }
            ]))
            ->executeOrFail($this->executor)
            ->isOk();
    }

    public function resetHead(ResetMode $mode): bool
    {
        return $this->reset($mode, 'HEAD~');
    }
}
