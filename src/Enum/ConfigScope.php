<?php

namespace ArtARTs36\GitHandler\Enum;

class ConfigScope
{
    use Enumerable;

    public const SUBMODULE = 'submodule';
    public const BRANCH = 'branch';
    public const USER = 'user';
    public const REMOTE = 'remote';
    public const CORE = 'core';
    public const PACK = 'pack';
}
