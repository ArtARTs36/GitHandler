<?php

namespace ArtARTs36\GitHandler\Support;

/**
 * Class Str
 * @package ArtARTs36\HostReviewerCore\Support
 */
class Str
{
    /**
     * @param string $haystack
     * @param string $needle
     * @return bool
     */
    public static function contains(string $haystack, string $needle): bool
    {
        return (bool) preg_match("/{$needle}/i", $haystack);
    }
}
