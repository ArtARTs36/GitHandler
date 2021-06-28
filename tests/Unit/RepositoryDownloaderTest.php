<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\GitSimpleFactory;
use ArtARTs36\GitHandler\RepositoryDownloader;
use ArtARTs36\GitHandler\Tests\Support\ArrayFileSystem;
use ArtARTs36\GitHandler\Tests\Support\MockHttpClient;
use Psr\Http\Message\RequestInterface;

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

    /**
     * @covers \ArtARTs36\GitHandler\RepositoryDownloader::createRequestOnFetch
     */
    public function testCreateRequestOnFetch(): void
    {
        $downloader = new RepositoryDownloader(
            GitSimpleFactory::factoryOriginUrlSelector(),
            MockHttpClient::good('test-file'),
            new ArrayFileSystem()
        );

        /** @var RequestInterface $result */
        $result = $this->callMethodFromObject(
            $downloader,
            'createRequestOnFetch',
            $this->mockHasRemotes('https://github.com/ArtARTs36/GitHandler.git')
        );

        self::assertEquals(
            (string) $result->getUri(),
            'https://codeload.github.com/ArtARTs36/GitHandler/zip/refs/heads/master'
        );
    }
}
