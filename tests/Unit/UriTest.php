<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Exceptions\GivenInvalidUri;
use ArtARTs36\GitHandler\Support\Uri;

final class UriTest extends TestCase
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

    public function providerForTestHost(): array
    {
        return [
            ['http://site.ru', 'site.ru',],
            ['site.ru', 'site.ru'],
            ['site.ru 1234', 'site.ru'],
        ];
    }

    /**
     * @dataProvider providerForTestHost
     * @covers \ArtARTs36\GitHandler\Support\Uri::host
     */
    public function testHost(string $input, string $expected): void
    {
        self::assertEquals($expected, Uri::host($input));
    }

    /**
     * @covers \ArtARTs36\GitHandler\Support\Uri::host
     */
    public function testHostOnInvalidUrl(): void
    {
        self::expectException(GivenInvalidUri::class);

        Uri::host('random');
    }
}
