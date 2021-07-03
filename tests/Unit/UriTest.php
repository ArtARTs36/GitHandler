<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Support\Uri;

class UriTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Support\Uri::unParse
     */
    public function testUnParseUrl(): void
    {
        self::assertEquals('https://site.ru/folder', Uri::unParse([
            'scheme' => 'https',
            'host'   => 'site.ru',
            'path'   => 'folder',
        ]));
    }
}
