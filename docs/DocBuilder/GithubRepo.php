<?php

namespace ArtARTs36\GitHandler\DocBuilder;

use ArtARTs36\GitHandler\Data\Repo;
use ArtARTs36\Str\Str;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Stream;
use Psr\Http\Client\ClientInterface;

class GithubRepo
{
    private $client;

    private $host;

    private $data;

    private $token;

    public function __construct(
        ClientInterface $client,
        string $host,
        Repo $data,
        string $token
    ) {
        $this->client = $client;
        $this->host = $host;
        $this->data = $data;
        $this->token = $token;
    }

    /**
     * @return array<RemoteTag>
     */
    public function getTags(): array
    {
        $query = json_encode(['query' => 'query ListTags {
  repository(owner: "'. $this->data->user .'", name: "'. $this->data->name . '") {
    releases(first: 50, orderBy: {field: CREATED_AT, direction: ASC}) {
      edges {
        node {
          descriptionHTML
          description
          name
          tagName
          publishedAt
        }
      }
    }
  }
}
']);

        $request = (new Request('POST', 'https://'. $this->host . '/graphql'))
            ->withBody(new Stream(fopen('data://text/plain,' . $query, 'r')))
            ->withHeader('Authorization', 'bearer ' . $this->token);

        $releases = json_decode($this->client->sendRequest($request)->getBody()->getContents(), true)
            ['data']['repository']['releases']['edges'];

        return array_map(function (array $item) {
            $item = $item['node'];

            return new RemoteTag(
                Str::make($item['description']),
                $item['tagName'],
                $item['name'],
                new \DateTime($item['publishedAt'])
            );
        }, $releases);
    }
}
