<?php

namespace ArtARTs36\GitHandler\Tests\Unit;

use ArtARTs36\GitHandler\Support\SimpleHttpClient;
use GuzzleHttp\Psr7\Request;

class SimpleHttpClientTest extends TestCase
{
    /**
     * @covers \ArtARTs36\GitHandler\Support\SimpleHttpClient::sendRequest
     */
    public function testSendRequest(): void
    {
        $client = new SimpleHttpClient();

        //

        $response = $client->sendRequest(
            new Request('GET', 'php://filter/read=string.toupper/resource=data:,')
        );

        self::assertEmpty($response->getBody()->getContents());
        self::assertEquals(404, $response->getStatusCode());

        //

        $response = $client->sendRequest(
            new Request('GET', 'php://filter/read=string.toupper/resource=data:,hello')
        );

        self::assertEquals('HELLO', $response->getBody()->getContents());
        self::assertEquals(200, $response->getStatusCode());
    }
}
