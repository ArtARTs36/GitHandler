<?php

namespace ArtARTs36\GitHandler\Enum;

use ArtARTs36\GitHandler\Support\Enumerable;

class StatusResult
{
    use Enumerable;

    public const GROUP_MODIFIED = 'M';
    public const GROUP_ADDED = 'AM';
    public const GROUP_UNTRACKED = '??';
}
