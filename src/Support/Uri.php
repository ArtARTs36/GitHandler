<?php

namespace ArtARTs36\GitHandler\Support;

use JetBrains\PhpStorm\ArrayShape;

class Uri
{
    public static function unParse(
        #[ArrayShape(['scheme' => 'string', 'host' => 'string', 'path' => 'string'])]
        array $parts
    ): string {
        return implode('/', [
            $parts['scheme'] . ':/',
            $parts['host'],
            $parts['path'],
        ]);
    }
}
