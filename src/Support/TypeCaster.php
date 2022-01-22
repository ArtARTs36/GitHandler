<?php

namespace ArtARTs36\GitHandler\Support;

class TypeCaster
{
    public static function boolean(string $raw): bool
    {
        return $raw === 'true';
    }

    /**
     * @param array<string, mixed> $raw
     */
    public static function string(array $raw, string $key): string
    {
        return array_key_exists($key, $raw) ? $raw[$key] : '';
    }

    /**
     * @param array<string, mixed> $raw
     */
    public static function integer(array $raw, string $key, int $default = 0): int
    {
        return array_key_exists($key, $raw) ? (int) $raw[$key] : $default;
    }
}
