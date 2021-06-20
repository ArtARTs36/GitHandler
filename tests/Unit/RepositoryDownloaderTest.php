<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\GitSimpleFactory;
use ArtARTs36\GitHandler\RepositoryDownloader;
use ArtARTs36\GitHandler\Tests\Support\ArrayFileSystem;
use ArtARTs36\GitHandler\Tests\Support\MockHttpClient;

class RepositoryDownloaderTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\RepositoryDownloader::download
     */
    public function testDownload(): void
    {
        $downloader = new RepositoryDownloader(
            GitSimpleFactory::factoryOriginUrlSelector(),
            MockHttpClient::good('test-file'),
            $fileSystem = new ArrayFileSystem()
        );

        $pathToSave = __DIR__ . '/archive.zip';

        $downloader->download($this->mockHasRemotes('https://github.com/ArtARTs36/GitHandler.git'), $pathToSave);

        self::assertTrue($fileSystem->exists($pathToSave));
    }

    /**
     * @covers \ArtARTs36\GitHandler\RepositoryDownloader::fetch
     */
    public function testFetch(): void
    {
        $downloader = new RepositoryDownloader(
            GitSimpleFactory::factoryOriginUrlSelector(),
            MockHttpClient::good('test-file'),
            new ArrayFileSystem()
        );

        $result = $this->callMethodFromObject(
            $downloader,
            'fetch',
            $this->mockHasRemotes('https://github.com/ArtARTs36/GitHandler.git')
        );

        self::assertEquals('test-file', $result);
    }
}
