<?php

namespace ArtARTs36\GitHandler\Support;

use ArtARTs36\GitHandler\Exceptions\GivenInvalidUri;
use ArtARTs36\Str\Str;
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

    public static function host(string $uri): string
    {
        $host = parse_url($uri, PHP_URL_HOST);

        if ($host !== null) {
            return $host;
        }

        $find = Str::make($uri)
            ->trim()
            ->match('/([a-zA-Z0-9\-\.]+)\.(com|org|net|mil|edu|ru|COM|ORG|NET|MIL|EDU|RU)/', 0, 0, false);

        if ($find->isNotEmpty()) {
            return $find;
        }

        throw new GivenInvalidUri($uri);
    }
}
