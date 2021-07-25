<?php

namespace ArtARTs36\GitHandler\Operations;

use ArtARTs36\GitHandler\Support\HookName;

trait HookOperations
{
    /**
     * @see HookName for $name
     */
    public function addHook(string $name, string $script): bool
    {
        return $this
                ->getFileSystem()
                ->createFile($this->getHookPath($name), $script) && $this->hasHook($name);
    }

    /**
     * @see HookName for $name
     */
    public function hasHook(string $name): bool
    {
        return $this->getFileSystem()->exists($this->getHookPath($name));
    }

    protected function getHookPath(string $name): string
    {
        return $this->pathToGitFolder() . DIRECTORY_SEPARATOR . 'hooks'. DIRECTORY_SEPARATOR . $name;
    }
}
