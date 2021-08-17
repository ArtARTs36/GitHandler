<?php

namespace ArtARTs36\GitHandler\Enum;

use ArtARTs36\GitHandler\Support\Enumerable;

class ResetMode
{
    use Enumerable;

    public const SOFT = 'soft';
    public const HARD = 'hard';
    public const MIXED = 'mixed';
}