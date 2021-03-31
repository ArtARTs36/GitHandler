<?php

namespace ArtARTs36\GitHandler;

use ArtARTs36\GitHandler\Contracts\HasRemotes;
use ArtARTs36\GitHandler\Origin\Url\OriginUrlFactory;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientInterface;

class RepositoryDownloader
{
    protected $url;

    protected $client;

    public function __construct(OriginUrlFactory $url, ClientInterface $client)
    {
        $this->url = $url;
        $this->client = $client;
    }

    public function download(HasRemotes $git, string $pathToSave): bool
    {
        return file_put_contents($pathToSave, $this->fetch($git)) !== false;
    }

    protected function fetch(HasRemotes $git)
    {
        return $this->client->sendRequest(
            new Request('GET', $this->url->factory($git)->toArchive($git))
        )->getBody()->getContents();
    }
}
