<?php

namespace ArtARTs36\GitHandler\Backup;

use ArtARTs36\FileSystem\Contracts\FileSystem;
use ArtARTs36\GitHandler\Contracts\Handler\GitHandler;
use ArtARTs36\GitHandler\Contracts\Backup\GitBackup;
use ArtARTs36\GitHandler\Contracts\Backup\GitBackupBuilding;

abstract class AbstractBackup implements GitBackup
{
    /**
     * Execute dump backup
     */
    abstract protected function doDump(string $path, GitBackupBuilding $building): void;

    /**
     * Execute restore backup
     */
    abstract protected function doRestore(string $path, GitBackupBuilding $building): void;

    protected $git;

    protected $files;

    protected $building;

    public function __construct(GitHandler $git, FileSystem $files, GitBackupBuilding $building)
    {
        $this->git = $git;
        $this->files = $files;
        $this->building = $building;
    }

    public function dump(string $path): void
    {
        $this->doDump($path, $this->building);
    }

    public function dumpOnly(string $path, array $elements): void
    {
        $this->doDump($path, $this->building->only($elements));
    }

    public function restore(string $path): void
    {
        $this->doRestore($path, $this->building);
    }

    public function restoreOnly(string $path, array $elements): void
    {
        $this->doRestore($path, $this->building->only($elements));
    }
}
