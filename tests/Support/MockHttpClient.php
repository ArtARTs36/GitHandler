<?php

namespace ArtARTs36\GitHandler\Tests\Support;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class MockHttpClient implements ClientInterface
{
    protected $status;

    protected $content;

    public function __construct(int $status, string $content)
    {
        $this->status = $status;
        $this->content = $content;
    }

    public static function good(string $content): self
    {
        return new static(200, $content);
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        if ($this->status !== 200) {
            throw new ClientException('', $request, new Response());
        }

        return new Response($this->status, [], $this->content);
    }
}
