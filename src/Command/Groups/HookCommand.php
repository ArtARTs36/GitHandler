<?php

namespace ArtARTs36\GitHandler\Command\Groups;

use ArtARTs36\GitHandler\Command\Groups\Contracts\GitHookCommand;
use ArtARTs36\GitHandler\Contracts\FileSystem;
use ArtARTs36\GitHandler\Data\Hook;
use ArtARTs36\GitHandler\Exceptions\HookNotExists;
use ArtARTs36\GitHandler\Data\GitContext;
use ArtARTs36\GitHandler\Support\Chmod;
use ArtARTs36\ShellCommand\Interfaces\ShellCommandExecutor;

class HookCommand implements GitHookCommand
{
    protected $fileSystem;

    protected $executor;

    protected $context;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(
        FileSystem $fileSystem,
        ShellCommandExecutor $executor,
        GitContext $context
    ) {
        $this->fileSystem = $fileSystem;
        $this->executor = $executor;
        $this->context = $context;
    }

    /**
     * @see HookName for $name
     */
    public function add(string $name, string $script): bool
    {
        $path = $this->doAdd($name, $script);

        Chmod::executable($path)->executeOrFail($this->executor);

        return $this->has($name);
    }

    public function get(string $name): Hook
    {
        if (! $this->has($name)) {
            throw new HookNotExists($name);
        }

        return $this->makeHookObject($name);
    }

    /**
     * @see HookName for $name
     */
    public function has(string $name): bool
    {
        return $this->fileSystem->exists($this->getHookPath($name));
    }

    /**
     * @see HookName for $name
     */
    public function delete(string $name): bool
    {
        if (! $this->has($name)) {
            throw new HookNotExists($name);
        }

        return $this->fileSystem->removeFile($this->getHookPath($name));
    }

    /**
     * @return array<string, Hook>
     */
    public function getAll(bool $onlyWorked = true): array
    {
        $map = [];
        $paths = $this->fileSystem->getFromDirectory($this->getHookPath());

        if ($onlyWorked) {
            $paths = array_filter($paths, function (string $path) {
                return empty(pathinfo($path, PATHINFO_EXTENSION));
            });
        }

        $existsNames = array_map(function (string $path) {
            return pathinfo($path, PATHINFO_BASENAME);
        }, $paths);

        foreach ($existsNames as $name) {
            $map[$name] = $this->makeHookObject($name);
        }

        return $map;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getHookPath(?string $name = null): string
    {
        return $this->context->getGitDir() . DIRECTORY_SEPARATOR . 'hooks'. DIRECTORY_SEPARATOR . $name;
    }

    protected function makeHookObject(string $name): Hook
    {
        return new Hook(
            $name,
            $this->fileSystem->getFileContent($path = $this->getHookPath($name)),
            $this->fileSystem->getLastUpdateDate($path)
        );
    }

    protected function doAdd(string $name, string $script): string
    {
        $this
            ->fileSystem
            ->createFile($path = $this->getHookPath($name), $script);

        return $path;
    }
}
