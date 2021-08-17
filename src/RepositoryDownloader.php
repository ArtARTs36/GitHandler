<?php

namespace ArtARTs36\GitHandler;

use ArtARTs36\GitHandler\Contracts\FileSystem;
use ArtARTs36\GitHandler\Contracts\Handler\HasRemotes;
use ArtARTs36\GitHandler\Exceptions\OriginUrlNotFound;
use ArtARTs36\GitHandler\Origin\Url\OriginUrlSelector;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;

class RepositoryDownloader
{
    protected $url;

    protected $client;

    protected $fileSystem;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(OriginUrlSelector $url, ClientInterface $client, FileSystem $fileSystem)
    {
        $this->url = $url;
        $this->client = $client;
        $this->fileSystem = $fileSystem;
    }

    /**
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function download(HasRemotes $git, string $pathToSave): bool
    {
        return $this->fileSystem->createFile($pathToSave, $this->fetch($git));
    }

    /**
     * @throws \Psr\Http\Client\ClientExceptionInterface
     * @throws OriginUrlNotFound
     */
    protected function fetch(HasRemotes $git): string
    {
        return $this->client->sendRequest($this->createRequestOnFetch($git))->getBody()->getContents();
    }

    protected function createRequestOnFetch(HasRemotes $git): RequestInterface
    {
        return new Request('GET', $this->url->select($git)->toArchive($git));
    }
}
