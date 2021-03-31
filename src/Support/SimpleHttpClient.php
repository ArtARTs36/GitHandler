<?php

namespace ArtARTs36\GitHandler\Support;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class SimpleHttpClient implements ClientInterface
{
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $content = file_get_contents($request->getUri()->__toString());

        $status = $content ? 200 : 404;

        return new Response($status, [], $content);
    }
}
