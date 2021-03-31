<?php

namespace ArtARTs36\GitHandler;

use ArtARTs36\GitHandler\Contracts\FileSystem;
use ArtARTs36\GitHandler\Contracts\HasRemotes;
use ArtARTs36\GitHandler\Origin\Url\OriginUrlSelector;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientInterface;

class RepositoryDownloader
{
    protected $url;

    protected $client;

    protected $fileSystem;

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
     */
    protected function fetch(HasRemotes $git): string
    {
        return $this->client->sendRequest(
            new Request('GET', $this->url->select($git)->toArchive($git))
        )->getBody()->getContents();
    }
}
