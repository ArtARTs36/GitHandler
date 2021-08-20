<?php

namespace ArtARTs36\GitHandler\Contracts\Commands;

/**
 * Switch folder
 */
interface FolderSwitchable
{
    /**
     * @return $this
     */
    public function seeToRoot();

    /**
     * @return $this
     */
    public function seeToFolder(string $folder);
}
