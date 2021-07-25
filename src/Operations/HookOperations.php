<?php

namespace ArtARTs36\GitHandler\Operations;

use ArtARTs36\GitHandler\Data\Hook;
use ArtARTs36\GitHandler\Exceptions\HookNotExists;
use ArtARTs36\GitHandler\Exceptions\UnexpectedException;
use ArtARTs36\GitHandler\Support\HookName;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\ShellCommand;
use ArtARTs36\Str\Str;

trait HookOperations
{
    abstract protected function newCommand(?string $dir = null): ShellCommandInterface;

    abstract protected function executeCommand(ShellCommand $command): ?Str;

    /**
     * @see HookName for $name
     */
    public function addHook(string $name, string $script): bool
    {
        $this
            ->getFileSystem()
            ->createFile($path = $this->getHookPath($name), $script);

        $res = $this->executeCommand(
            $cmd = (new ShellCommand('chmod'))->addParameter('+x')->addParameter($path)
        );

        if ($res !== null) {
            throw new UnexpectedException($cmd);
        }

        return $this->hasHook($name);
    }

    public function getHook(string $name): Hook
    {
        if (! $this->hasHook($name)) {
            throw new HookNotExists($name);
        }

        return new Hook(
            $name,
            $this->getFileSystem()->getFileContent($path = $this->getHookPath($name)),
            $this->getFileSystem()->getLastUpdateDate($path)
        );
    }

    /**
     * @see HookName for $name
     */
    public function hasHook(string $name): bool
    {
        return $this->getFileSystem()->exists($this->getHookPath($name));
    }

    /**
     * @see HookName for $name
     */
    public function deleteHook(string $name): bool
    {
        if (! $this->hasHook($name)) {
            throw new HookNotExists($name);
        }

        return $this->getFileSystem()->removeFile($this->getHookPath($name));
    }

    /**
     * @codeCoverageIgnore
     */
    public function getHookPath(string $name): string
    {
        return $this->pathToGitFolder() . DIRECTORY_SEPARATOR . 'hooks'. DIRECTORY_SEPARATOR . $name;
    }
}
