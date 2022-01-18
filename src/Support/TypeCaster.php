<?php

namespace ArtARTs36\GitHandler\Support;

class TypeCaster
{
    public static function boolean(string $raw): bool
    {
        return $raw === 'true';
    }

    public static function integer(array $raw, string $key, int $default = 0): int
    {
        return array_key_exists($key, $raw) ? (int) $raw[$key] : $default;
    }

    public static function string(array $raw, string $key): string
    {
        return array_key_exists($key, $raw) ? $raw[$key] : '';
    }
}
