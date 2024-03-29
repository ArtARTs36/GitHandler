<?php

namespace ArtARTs36\GitHandler\Enum;

use ArtARTs36\Str\Str;

class BranchBadName
{
    use Enumerable;

    public const NAME_HEAD = 'HEAD';

    public static function is(Str $branch): bool
    {
        return in_array($branch, static::cases()) || $branch->containsAny([
            '[', '..',
        ]);
    }
}
