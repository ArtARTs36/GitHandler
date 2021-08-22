<?php

namespace ArtARTs36\GitHandler\Tests\Unit\Factory;

use ArtARTs36\GitHandler\Factory\DownloaderFactory;
use ArtARTs36\GitHandler\Origin\Downloader;
use ArtARTs36\GitHandler\Support\SimpleHttpClient;
use ArtARTs36\GitHandler\Tests\Support\ArrayFileSystem;
use ArtARTs36\GitHandler\Tests\Unit\TestCase;

final class DownloaderFactoryTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Factory\DownloaderFactory::factory
     */
    public function testFactory(): void
    {
        $factory = $this->makeFactory();

        self::assertInstanceOf(Downloader::class, $factory->factory(new SimpleHttpClient(), new ArrayFileSystem()));
    }

    private function makeFactory(): DownloaderFactory
    {
        return new DownloaderFactory();
    }
}
