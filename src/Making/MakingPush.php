<?php

namespace ArtARTs36\GitHandler\Making;

use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use Psr\Http\Message\UriInterface;

class MakingPush
{
    protected $remote;

    protected $branch = null;

    protected $isForce = false;

    public function __construct(UriInterface $remote)
    {
        $this->remote = $remote;
    }

    public function onRemote(callable $setup): self
    {
        $this->remote = $setup($this->remote);

        return $this;
    }

    public function onBranch(string $branch): self
    {
        $this->branch = $branch;

        return $this;
    }

    public function onBranchHead(string $branch): self
    {
        return $this->onBranch('HEAD:' . $branch);
    }

    public function force(): self
    {
        $this->isForce = true;

        return $this;
    }

    public function buildCommand(ShellCommandInterface $command): ShellCommandInterface
    {
        return $command
            ->addArgument('push')
            ->addArgument($this->remote->__toString())
            ->when($this->branch !== null, function (ShellCommandInterface $command) {
                $command->addArgument($this->branch);
            })
            ->when($this->isForce, function (ShellCommandInterface $command) {
                $command->addOption('force');
            });
    }
}