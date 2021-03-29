<?php

namespace ArtARTs36\GitHandler\Support;

class TypeCaster
{
    public static function boolean(string $raw): bool
    {
        return $raw === 'true';
    }
}
