<?php

namespace ArtARTs36\GitHandler\Support;

use ArtARTs36\ShellCommand\Interfaces\ShellCommandInterface;
use ArtARTs36\ShellCommand\ShellCommand;

class Chmod
{
    /**
     * @codeCoverageIgnore
     */
    public static function executable(string $path): ShellCommandInterface
    {
        return (new ShellCommand('chmod'))->addParameter('+x')->addParameter($path);
    }
}
