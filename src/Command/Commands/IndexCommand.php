<?php

namespace ArtARTs36\GitHandler\Command\Commands;

use ArtARTs36\GitHandler\Contracts\Commands\GitIndexCommand;
use ArtARTs36\GitHandler\Enum\ResetMode;
use ArtARTs36\GitHandler\Exceptions\FileNotFound;
use ArtARTs36\GitHandler\Exceptions\UnknownRevisionInWorkingTree;
use ArtARTs36\ShellCommand\Exceptions\UserExceptionTrigger;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\Result\CommandResult;

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
                function (CommandResult $result) {
                    FileNotFound::handleIfSo($result->getError());
                }
            ]))
            ->executeOrFail($this->executor)
            ->isOk();
    }

    public function remove($files, bool $force = false): void
    {
        $this
            ->buildRemoveCommand($force)
            ->executeOrFail($this->executor);
    }

    public function removeCached($files, bool $force = false): void
    {
        $this
            ->buildRemoveCommand($force)
            ->addOption('cached')
            ->addArguments((array) $files)
            ->executeOrFail($this->executor);
    }

    public function reset(ResetMode $mode, string $subject): void
    {
        $this
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
            ->executeOrFail($this->executor);
    }

    /**
     * @codeCoverageIgnore
     */
    public function resetHead(ResetMode $mode): void
    {
        $this->reset($mode, 'HEAD~');
    }

    public function rollback($paths): void
    {
        $this
            ->buildPureCheckoutCommand(array_merge(['HEAD'], (array) $paths), false)
            ->executeOrFail($this->executor);
    }

    public function checkout($path, bool $merge = false): bool
    {
        return $this
            ->buildPureCheckoutCommand((array) $path, $merge)
            ->executeOrFail($this->executor)
            ->isOk();
    }

    protected function buildPureCheckoutCommand(array $paths, bool $merge): ShellCommandInterface
    {
        return $this
            ->builder
            ->make()
            ->addArgument('checkout')
            ->addArguments($paths)
            ->when($merge, function (ShellCommandInterface $command) {
                $command->addOption('merge');
            })
            ->setExceptionTrigger(UserExceptionTrigger::fromCallbacks([
                function (CommandResult $result) {
                    FileNotFound::handleIfSo($result->getError());
                }
            ]));
    }

    protected function buildRemoveCommand(bool $force): ShellCommandInterface
    {
        return $this
            ->builder
            ->make()
            ->addArgument('rm')
            ->when($force, function (ShellCommandInterface $command) {
                $command->addOption('force');
            })
            ->setExceptionTrigger(UserExceptionTrigger::fromCallbacks([
                function (CommandResult $result) {
                    FileNotFound::handleIfSo($result->getError());
                }
            ]));
    }
}
