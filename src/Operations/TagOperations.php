<?php

namespace ArtARTs36\GitHandler\Operations;

use ArtARTs36\GitHandler\Exceptions\TagAlreadyExists;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\ShellCommand;
use ArtARTs36\Str\Str;

trait TagOperations
{
    abstract protected function newCommand(?string $dir = null): ShellCommandInterface;

    abstract protected function executeCommand(ShellCommand $command): ?Str;

    public function getTags(?string $pattern = null): array
    {
        $raw = $this
            ->executeCommand(
                $this
                    ->newCommand()
                    ->addParameter('tag')
                    ->when($pattern !== null, function (ShellCommand $command) use ($pattern) {
                        $command
                            ->addCutOption('l')
                            ->addParameter($pattern, true);
                    })
            );

        if ($raw === null || $raw->isEmpty()) {
            return [];
        }

        return $raw->trim()->lines();
    }

    /**
     * @throws TagAlreadyExists
     */
    public function performTag(string $tag, ?string $message = null): bool
    {
        if ($this->isTagExists($tag)) {
            throw new TagAlreadyExists($tag);
        }

        return $this->newCommand()
                ->addParameter('tag')
                ->addCutOption('a')
                ->addParameter($tag)
                ->addCutOption('m')
                ->addParameter($message ?? "Version {$tag}", true)
                ->getShellResult() === null;
    }

    public function isTagExists(string $tag): bool
    {
        return in_array($tag, $this->getTags());
    }
}
