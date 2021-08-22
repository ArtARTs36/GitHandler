<?php

namespace ArtARTs36\GitHandler\Contracts\Commands;

/**
 * Switch folder
 */
interface FolderSwitchable
{
    /**
     * Switch folder to root (project dir)
     * @return $this
     */
    public function seeToRoot();

    /**
     * Switch folder
     * @return $this
     */
    public function seeToFolder(string $folder);
}
