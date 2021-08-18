<?php

namespace ArtARTs36\GitHandler\Enum;

class StatusResult
{
    use Enumerable;

    public const GROUP_MODIFIED = 'M';
    public const GROUP_ADDED = 'AM';
    public const GROUP_UNTRACKED = '??';
}
