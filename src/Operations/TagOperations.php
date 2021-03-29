<?php

namespace ArtARTs36\GitHandler\Operations;

use ArtARTs36\GitHandler\Exceptions\TagAlreadyExist;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\ShellCommand;
use ArtARTs36\Str\Str;

trait TagOperations
{
    abstract protected function newCommand(?string $dir = null): ShellCommandInterface;

    abstract protected function executeCommand(ShellCommand $command): ?Str;

    public function getTags(?string $pattern = null): array
    {
        $raw = $this->newCommand()
            ->addParameter('tag')
            ->when($pattern !== null, function (ShellCommand $command) use ($pattern) {
                $command
                    ->addCutOption('l')
                    ->addParameter($pattern, true);
            })
            ->getShellResult();

        if (empty($raw)) {
            return [];
        }

        return explode("\n", trim($raw));
    }

    /**
     * @throws TagAlreadyExist
     */
    public function performTag(string $tag, ?string $message = null): bool
    {
        if ($this->isTagExists($tag)) {
            throw new TagAlreadyExist($tag);
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
