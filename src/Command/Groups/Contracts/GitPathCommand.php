<?php

namespace ArtARTs36\GitHandler\Command\Groups\Contracts;

/**
 * Git paths (info-path, html-path, man-path, ...)
 */
interface GitPathCommand
{
    /**
     * Get git info path
     * @git-command git --info-path
     */
    public function info(): string;

    /**
     * Get git html path
     * @git-command git --html-path
     */
    public function html(): string;

    /**
     * Get git info path
     * @git-command git --man-path
     */
    public function man(): string;
}
